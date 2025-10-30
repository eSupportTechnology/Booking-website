<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Property;
use App\Models\Room;
use App\Models\PropertyFacility;
use Carbon\Carbon;

class SearchController extends Controller
{
    /**
     * Main search handler - returns search results view with:
     *  - $properties (paginated)
     *  - $filterGroups (labels + dynamic counts)
     *  - $filterCounts (property_type counts map)
     *  - $searchData (to prefill front-end)
     */
    public function search(Request $request)
    {
        // Basic validation (keeps it light; adapt as needed)
        $request->validate([
            'checkIn' => ['nullable', 'date'],
            'checkOut' => ['nullable', 'date', 'after_or_equal:checkIn'],
            'adults' => ['nullable', 'integer', 'min:0'],
            'children' => ['nullable', 'integer', 'min:0'],
            'rooms' => ['nullable', 'integer', 'min:1'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        // Start building query: only active and open for bookings
        $query = Property::query()
            ->where('status', 'active')
            ->where('open_for_bookings', 1)
            ->with(['files', 'facilities', 'rooms']) // Eager load what template uses
            ->withCount('reviews')                    // reviews_count
            ->withAvg('reviews', 'rating')            // reviews_avg_rating
            ->withMin('rooms', 'price_per_night');    // rooms_min_price_per_night

        // ---------- APPLY FILTERS FROM REQUEST ----------
        // Destination keyword (city/country/address/title)
        if ($request->filled('destination')) {
            $destination = trim($request->input('destination'));
            $query->where(function ($q) use ($destination) {
                $q->where('city', 'LIKE', "%{$destination}%")
                  ->orWhere('country', 'LIKE', "%{$destination}%")
                  ->orWhere('address', 'LIKE', "%{$destination}%")
                  ->orWhere('title', 'LIKE', "%{$destination}%");
            });
        }

        // Date availability: exclude properties having overlapping bookings
        if ($request->filled('checkIn') && $request->filled('checkOut')) {
            $checkIn  = $request->input('checkIn');
            $checkOut = $request->input('checkOut');

    // ✅ precise room-level availability filter
            $query->whereHas('rooms', function ($q) use ($checkIn, $checkOut) {
                $q->whereDoesntHave('bookings', function ($b) use ($checkIn, $checkOut) {
                    $b->where(function ($bb) use ($checkIn, $checkOut) {
                        $bb->where('check_in', '<', $checkOut)
                           ->where('check_out', '>', $checkIn)
                           ->whereIn('status', ['pending', 'confirmed']);
                    });
                });
            });
        }

        // Guests (adults + children): require at least one room with capacity
        if ($request->filled('adults') || $request->filled('children')) {
            $adults = (int) $request->input('adults', 0);
            $children = (int) $request->input('children', 0);
            $totalGuests = $adults + $children;
            if ($totalGuests > 0) {
                $query->whereHas('rooms', function ($q) use ($totalGuests) {
                    $q->where('max_guests', '>=', $totalGuests);
                });
            }
        }

        // Rooms count required: ensure property has enough rooms (approximation)
        if ($request->filled('rooms')) {
            $roomsNeeded = max(1, (int) $request->input('rooms'));
            $query->whereHas('rooms', function ($q) use ($roomsNeeded) {
                // We cannot check available room counts easily without complex booking logic;
                // this checks property has at least N rooms defined.
                $q->select(DB::raw('property_id'))
                  ->groupBy('property_id')
                  ->havingRaw('COUNT(id) >= ?', [$roomsNeeded]);
            });
        }

        // Budget (min / max) applied to rooms.price_per_night
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $min = (float)$request->input('min_price', 0);
            $max = (float)$request->input('max_price', 99999999);
            $query->whereHas('rooms', function ($q) use ($min, $max) {
                $q->whereBetween('price_per_night', [$min, $max]);
            });
        }

        // Property type (category id or group)
        if ($request->filled('property_type')) {
            $pt = $request->input('property_type');
            if (is_numeric($pt)) {
                $query->where('category_id', (int)$pt);
            } else {
                $query->where(function ($q) use ($pt) {
                    $q->where('group', $pt)
                      ->orWhere('stars', $pt)
                      ->orWhere('subtype_id', $pt);
                });
            }
        }

        // Stars / ratings selection (array expected)
        if ($request->filled('property_rating')) {
            $ratings = (array) $request->input('property_rating');
            $ratings = array_map('intval', $ratings);
            if (!empty($ratings)) $query->whereIn('stars', $ratings);
        }

        // Facilities (array of facility names)
        if ($request->filled('facilities')) {
            $facilities = (array)$request->input('facilities');
            if (!empty($facilities)) {
                $query->whereHas('facilities', function ($q) use ($facilities) {
                    $q->whereIn('facility_name', $facilities);
                });
            }
        }

        // Property amenities (amenities pivot)
        if ($request->filled('amenities')) {
            $amenities = (array)$request->input('amenities');
            if (!empty($amenities)) {
                $query->whereHas('amenities', function ($q) use ($amenities) {
                    $q->whereIn('amenities.name', $amenities);
                });
            }
        }

        // Review score (min_score)
        if ($request->filled('min_score')) {
            $minScore = (float)$request->input('min_score', 0);
            // we have reviews_avg_rating via withAvg('reviews', 'rating') but cannot filter by alias easily;
            // use havingRaw on subquery (MySQL) — fallback to join on reviews aggregated table is more robust.
            $query->whereHas('reviews', function ($q) use ($minScore) {
                $q->select(DB::raw('property_id, AVG(rating) as avg_rating'))
                  ->groupBy('property_id')
                  ->havingRaw('AVG(rating) >= ?', [$minScore]);
            });
        }

        // Pets allowed (from property_policies.pets_allowed or property_services.parking etc.)
        if ($request->boolean('pets')) {
            $query->whereHas('policies', function ($q) {
                $q->whereNotNull('pets_allowed')->where('pets_allowed', '!=', '');
            });
        }

        // Search keywords in title/description
        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($qq) use ($q) {
                $qq->where('title', 'LIKE', "%{$q}%")
                   ->orWhere('description', 'LIKE', "%{$q}%");
            });
        }

        // Sort options
        $sort = $request->input('sort', null);
        switch ($sort) {
            case 'price_low_high':
                $query->orderBy('rooms_min_price_per_night', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('rooms_min_price_per_night', 'desc');
                break;
            case 'rating_high_low':
                // if stars stored as string, cast or use orderByRaw
                $query->orderByRaw('CAST(stars AS UNSIGNED) DESC');
                break;
            case 'most_reviewed':
                $query->orderByDesc('reviews_count');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Paginate and keep query string
        $perPage = 12;
        $properties = $query->paginate($perPage)->appends($request->query());

        // --------------------------
        // Build dynamic filter groups
        // --------------------------
        // We will use cached counts for a short period to avoid slamming DB on high traffic
        $cacheTtl = 60; // seconds; adjust as needed

        // templateGroups mirrors the Blade groups and labels
         $templateGroups = [
            'popular' => ['Swimming pool', 'Beach', 'Private bathroom', 'Breakfast included', 'Restaurant'],
            'meals' => ['Breakfast included', 'All meals included'],
            'property_type' => ['Family friendly properties','Hotels','Guest houses','Apartments','Villas','Homestays','Bed and breakfasts','Holiday homes','Resorts','Hostels','Lodges','Campsites','Chalets','Country houses','Luxury tents','Farm stays','Boats','Holiday parks','Capsule hotels','Motels','Love hotels','Economy hotels'],
            'travel_group' => ['Pets allowed','Family friendly properties','Travel Proud (LGBTQ+ friendly)'],
            'certifications' => ['Sustainability certification'],
            'entire_places' => ['Entire homes & apartments'],
            'room_facility' => ["Children's high chair", "Coffee/tea maker", "Electric kettle", "View", "Soundproofing", "Patio", "Washing machine", "Flat-screen TV", "Balcony", "Terrace", "Bath", "Desk", "Air conditioning", "Kitchenette", "Private bathroom", "Kitchen/kitchenette"],
            'facility' => ["Parking", "Restaurant", "Room service", "24-hour front desk", "Fitness centre", "Non-smoking rooms", "Airport shuttle", "Spa and wellness centre", "Hot tub/Jacuzzi", "Free WiFi", "Electric vehicle charging station", "Wheelchair accessible"],
            'destination' => ["Galle District","Matara District","Kandy District","Gampaha District","Badulla District","Colombo District","Matale District","Hambantota District","Nuwara Eliya District","Anuradhapura District","Ratnapura District","Trincomalee District","Ampara District","Kalutara District","Puttalam District","Jaffna District","Monaragala District","Polonnaruwa District","Kegalle District","Batticaloa District","Kurunegala District","Mannar District","Kilinochchi District","Vavuniya District","Mullaitivu District"],
            'brand' => ["Jetwing Hotels Limited","Cinnamon Hotels & Resorts","Thema Collection","Aitken Spence Hotels","Your.Rentals","Hilton Hotels & Resorts","OYO Rooms","Ramada","Shangri-La Group","Anantara Hotels & Resorts","Radisson","Yoho Bed","Sheraton","Collection by Aston","GRANBELL HOTELS & RESORTS","Best Western","Marriott Hotels & Resorts","Courtyard by Marriott","Doubletree by Hilton","Berjaya Hotels & Resorts"],
            'city' => ["Kandy","Hikkaduwa","Ella","Weligama","Galle","Negombo","Nuwara Eliya","Mirissa","Ahangama","Unawatuna","Tangalle","Sigiriya","Anuradhapura","Colombo","Matara","Arugam Bay","Dickwella","Trincomalee","Bentota","Udawalawe","Dambulla","Tissamaharama","Katunayake","Jaffna","Nikawatawana"],
            'landmark' => ["Ella Railway Station","Negombo Beach Park","Sri Dalada Maligawa","Temple of Tooth Relic","Nuwara Eliya Golf Club","Galle International Cricket Stadium","Galle Railway Station","Tangalle Lagoon","Galle Fort","Bentota Lake","Kandy Lake","Gregory Lake","Paradise Road","Demodara Nine Arch Bridge","Galle Light house","Turtle Farm","Sigiriya Museum","Japanese Peace Pagoda","Dambulla Cave Temple","Yatagala Temple","Sigiriya Rock","Laksala","Angurukaramulla Temple","Habarana Lake","Haputale Railway Station"],
            'activity' => ["Bicycle rental","Beach","Walking tours","Bike tours","Cycling"],
            'prop_accessibility' => ['Toilet with grab rails','Higher level toilet','Lower bathroom sink','Emergency cord in bathroom','Visual aids: Braille','Visual aids: Tactile signs','Auditory guidance'],
            'room_accessibility' => ['Entire unit located on ground floor','Upper floors accessible by elevator','Entire unit wheelchair accessible','Toilet with grab rails','Adapted bath','Roll-in shower','Walk-in shower','Raised toilet','Lowered sink','Emergency cord in bathroom','Shower chair'],
        ];

        // Helper closure to count via property_facilities table
        $countPropertiesWithFacility = function ($name) {
            return DB::table('property_facilities')->where('facility_name', $name)->distinct('property_id')->count('property_id');
        };

        // Simple counts for cities / group / keywords
        $countPropertiesWithCity = function ($cityName) {
            return DB::table('properties')->where('city', 'LIKE', "%{$cityName}%")->count();
        };

        $countPropertiesWithGroup = function ($groupName) {
            return DB::table('properties')->where('group', $groupName)->count();
        };

        // Build filterGroups array for the Blade
        $filterGroups = [];
        foreach ($templateGroups as $groupKey => $items) {
            $itemsWithCounts = [];
            foreach ($items as $label) {
                // Use cache for each label count
                $cacheKey = "filter_count:{$groupKey}:" . md5($label);
                $count = Cache::remember($cacheKey, $cacheTtl, function () use ($label, $countPropertiesWithFacility, $countPropertiesWithCity, $countPropertiesWithGroup) {
                    $c = 0;
                    // facility table first
                    $c = $countPropertiesWithFacility($label);
                    if ($c === 0) {
                        // maybe it's a city/district/landmark stored in properties table
                        $c = $countPropertiesWithCity($label);
                    }
                    if ($c === 0) {
                        // maybe it's stored in group column
                        $c = $countPropertiesWithGroup($label);
                    }
                    return $c;
                });

                $itemsWithCounts[$label] = $count;
            }

            $title = ucwords(str_replace('_', ' ', $groupKey));
            $idPrefix = str_replace('_', '-', $groupKey);

            $filterGroups[] = [
                'title' => $title,
                'name' => $groupKey,
                'id_prefix' => $idPrefix,
                'items' => $itemsWithCounts,
                'visible_count' => 5, // change to configure initial visible items
            ];
        }

        // property_type counts: group by 'group' column (fallback) and by category_id
        $propertyTypes = Cache::remember('filter_counts:property_type', $cacheTtl, function () {
            return DB::table('properties')
                ->select(DB::raw("COALESCE(`group`, 'Other') as prop_group"), DB::raw('count(*) as total'))
                ->groupBy('prop_group')
                ->orderByDesc('total')
                ->pluck('total', 'prop_group')
                ->toArray();
        });

        $filterCounts = [
            'property_type' => $propertyTypes,
        ];

        // Collect current search input values for Alpine/Blade prefill
        $searchData = [
            'destination' => $request->input('destination', ''),
            'checkIn' => $request->input('checkIn', ''),
            'checkOut' => $request->input('checkOut', ''),
            'adults' => (int)$request->input('adults', 2),
            'children' => (int)$request->input('children', 0),
            'rooms' => (int)$request->input('rooms', 1),
            'pets' => $request->boolean('pets', false),
            'q' => $request->input('q', ''),
        ];

        // Return view
        return view('Customer.search-results', compact('properties', 'filterGroups', 'filterCounts', 'searchData'));
    }

    /**
     * showSearchForm - for the landing/search form page
     * Keeps helpful lightweight data preloaded (cities, guest ranges, pet availability)
     */
    public function showSearchForm()
    {
        // Cache short-lived for performance
        $cacheTtl = 60;

        $cities = Cache::remember('search_form:cities', $cacheTtl, function () {
            return Property::whereNotNull('city')
                ->where('status', 'active')
                ->distinct()
                ->orderBy('city')
                ->pluck('city');
        });

        $maxGuests = Cache::remember('search_form:max_guests', $cacheTtl, function () {
            return Room::max('max_guests') ?? 4;
        });

        $minGuests = Cache::remember('search_form:min_guests', $cacheTtl, function () {
            return Room::min('max_guests') ?? 1;
        });

        $maxRooms = Cache::remember('search_form:max_rooms', $cacheTtl, function () {
            return Room::select('property_id')
                ->groupBy('property_id')
                ->selectRaw('COUNT(id) as room_count')
                ->get()
                ->max('room_count') ?? 3;
        });

        $hasPetFriendly = Cache::remember('search_form:has_pet_friendly', $cacheTtl, function () {
            return PropertyFacility::where('facility_name', 'like', '%pet%')->exists()
                || DB::table('property_policies')->whereNotNull('pets_allowed')->where('pets_allowed', '!=', '')->exists();
        });

        // Next available check-in / check-out (optional hints)
        $nextAvailableCheckIn = Cache::remember('search_form:next_checkin', $cacheTtl, function () {
            return DB::table('bookings')->whereDate('check_in', '>', now())->min('check_in');
        });

        $nextAvailableCheckOut = Cache::remember('search_form:next_checkout', $cacheTtl, function () {
            return DB::table('bookings')->whereDate('check_out', '>', now())->max('check_out');
        });

        return view('Customer.search-form', compact(
            'cities', 'minGuests', 'maxGuests', 'maxRooms', 'hasPetFriendly',
            'nextAvailableCheckIn', 'nextAvailableCheckOut'
        ));
    }

        public function ajaxSearch(Request $request)
    {
        $response = $this->search($request); // reuse same filtering logic
        $properties = $response->getData()['properties'];

        return response()->json([
            'html' => view('Customer._searchResults', compact('properties'))->render()
        ]);
    }
}