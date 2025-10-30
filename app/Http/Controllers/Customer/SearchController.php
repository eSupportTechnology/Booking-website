<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Property;

class SearchController extends Controller
{
    /**
     * Handle search and render the search results page.
     * Returns:
     *  - $properties (paginated)
     *  - $filterGroups (labels + dynamic counts)
     *  - $filterCounts (property_type counts map)
     */
    public function search(Request $request)
    {
        // Base query: only active properties open for bookings
        $query = Property::query()
            ->where('status', 'active')
            ->where('open_for_bookings', 1)
            ->with(['files', 'facilities', 'rooms']) // eager load relations we'll use
            ->withCount('reviews') // optional if reviews relation exists
            ->withAvg('reviews', 'rating') // optional if reviews relation exists
            ->withMin('rooms', 'price_per_night'); // exposes rooms_min_price_per_night

        // --- apply filters from request (safe via Eloquent) ---

        // Destination (city/country/address)
        if ($request->filled('destination')) {
            $destination = $request->input('destination');
            $query->where(function ($q) use ($destination) {
                $q->where('city', 'LIKE', "%{$destination}%")
                  ->orWhere('country', 'LIKE', "%{$destination}%")
                  ->orWhere('address', 'LIKE', "%{$destination}%");
            });
        }

        // Dates: exclude properties with bookings that overlap the requested range
        if ($request->filled('checkIn') && $request->filled('checkOut')) {
            $checkIn = $request->input('checkIn');
            $checkOut = $request->input('checkOut');

            $query->whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut) {
                $q->where(function ($q2) use ($checkIn, $checkOut) {
                    $q2->whereBetween('check_in', [$checkIn, $checkOut])
                       ->orWhereBetween('check_out', [$checkIn, $checkOut])
                       ->orWhere(function ($q3) use ($checkIn, $checkOut) {
                           $q3->where('check_in', '<=', $checkIn)
                              ->where('check_out', '>=', $checkOut);
                       });
                });
            });
        }

        // Guests (adults + children)
        if ($request->filled('adults') || $request->filled('children')) {
            $totalGuests = (int)$request->input('adults', 0) + (int)$request->input('children', 0);
            if ($totalGuests > 0) {
                $query->whereHas('rooms', function ($q) use ($totalGuests) {
                    $q->where('max_guests', '>=', $totalGuests);
                });
            }
        }

        // Rooms count (if provided)
        if ($request->filled('rooms')) {
            $roomsNeeded = (int)$request->input('rooms');
            if ($roomsNeeded > 0) {
                $query->has('rooms', '>=', $roomsNeeded);
            }
        }

        // Budget: min_price / max_price against rooms.price_per_night
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $min = $request->input('min_price', 0);
            $max = $request->input('max_price', 99999999);
            $query->whereHas('rooms', function ($q) use ($min, $max) {
                $q->whereBetween('price_per_night', [(float)$min, (float)$max]);
            });
        }

        // Property type (category id or group string)
        if ($request->filled('property_type')) {
            $pt = $request->input('property_type');
            if (is_numeric($pt)) {
                $query->where('category_id', (int)$pt);
            } else {
                $query->where(function ($q) use ($pt) {
                    $q->where('group', $pt)
                      ->orWhere('stars', $pt)
                      ->orWhere('subtype_id', $pt); // fallback
                });
            }
        }

        // Stars (property rating)
        if ($request->filled('stars')) {
            $stars = (array) $request->input('stars');
            $query->whereIn('stars', $stars);
        }

        // Facilities filter (array of facility names)
        if ($request->filled('facilities')) {
            $facilities = (array)$request->input('facilities');
            $query->whereHas('facilities', function ($q) use ($facilities) {
                $q->whereIn('facility_name', $facilities);
            });
        }

        // Sort (optional)
        $sort = $request->input('sort', null);
        if ($sort) {
            switch ($sort) {
                case 'price_low_high':
                    $query->orderBy('rooms_min_price_per_night', 'asc');
                    break;
                case 'price_high_low':
                    $query->orderBy('rooms_min_price_per_night', 'desc');
                    break;
                case 'rating_high_low':
                    $query->orderBy('stars', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Paginate properties and preserve query string
        $properties = $query->paginate(12)->appends($request->query());

        // -------------------------
        // Build dynamic filter counts
        // We'll attempt to produce counts for the same labels used in the Blade.
        // -------------------------

        // Helper closures
        $countPropertiesWithFacility = function ($name) {
            return DB::table('property_facilities')
                ->where('facility_name', $name)
                ->distinct('property_id')
                ->count('property_id');
        };

        $countPropertiesWithCity = function ($cityName) {
            return DB::table('properties')->where('city', $cityName)->count();
        };

        $countPropertiesWithGroup = function ($groupName) {
            return DB::table('properties')->where('group', $groupName)->count();
        };

        // Template groups labels (match the Blade labels)
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

        // Collect all current search input values for pre-filling in the Blade
    $searchData = [
        'destination' => $request->input('destination', ''),
        'checkIn' => $request->input('checkIn', ''),
        'checkOut' => $request->input('checkOut', ''),
        'adults' => $request->input('adults', 2),
        'children' => $request->input('children', 0),
        'rooms' => $request->input('rooms', 1),
        'pets' => $request->boolean('pets', false),
    ];


        $filterGroups = [];
        foreach ($templateGroups as $groupKey => $items) {
            $itemsWithCounts = [];
            foreach ($items as $label) {
                $count = 0;
                // try facility
                $count = $countPropertiesWithFacility($label);
                if ($count === 0) {
                    // try city
                    $count = $countPropertiesWithCity($label);
                }
                if ($count === 0) {
                    // try group column
                    $count = $countPropertiesWithGroup($label);
                }
                $itemsWithCounts[$label] = $count;
            }

            $title = ucwords(str_replace('_', ' ', $groupKey));
            $idPrefix = str_replace('_', '-', $groupKey);

            $filterGroups[] = [
                'title' => $title,
                'name' => $groupKey,
                'id_prefix' => $idPrefix,
                'items' => $itemsWithCounts,
                'visible_count' => 5,
            ];
        }

        // property_type counts by grouping on properties.group (fallback)
        $propertyTypes = DB::table('properties')
            ->select('group', DB::raw('count(*) as total'))
            ->groupBy('group')
            ->orderByDesc('total')
            ->pluck('total', 'group')
            ->toArray();

        $filterCounts = [
            'property_type' => $propertyTypes,
        ];

        // Return view with dynamic data
        return view('Customer.search-results', compact('properties', 'filterGroups', 'filterCounts', 'searchData'));

    }

    public function showSearchForm()
{
    // 🏙️ Fetch all distinct cities from properties
    $cities = \App\Models\Property::whereNotNull('city')
        ->where('status', 'active')
        ->distinct()
        ->orderBy('city')
        ->pluck('city');

    // 🛏️ Fetch min and max guest capacities from rooms
    $maxGuests = \App\Models\Room::max('max_guests');
    $minGuests = \App\Models\Room::min('max_guests');

    // 🏠 Fetch room count range (property-wise)
    $maxRooms = \App\Models\Room::select('property_id')
        ->groupBy('property_id')
        ->selectRaw('COUNT(id) as room_count')
        ->max('room_count');

    // 🐾 Check if any property allows pets
    $hasPetFriendly = \App\Models\PropertyFacility::where('facility_name', 'like', '%pet%')->exists();

    // 📅 Optional: Fetch upcoming available dates
    $nextAvailableCheckIn = \App\Models\Booking::whereDate('check_in', '>', now())->min('check_in');
    $nextAvailableCheckOut = \App\Models\Booking::whereDate('check_out', '>', now())->max('check_out');

    return view('Customer.search-form', compact(
        'cities', 'minGuests', 'maxGuests', 'maxRooms', 'hasPetFriendly',
        'nextAvailableCheckIn', 'nextAvailableCheckOut'
    ));
}

}
