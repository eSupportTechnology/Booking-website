<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use App\Models\Property;
use App\Models\Room;
use App\Models\Amenity;
use App\Models\PropertyCategory;
use App\Models\PropertySubcategory;
use App\Models\PropertySubtype;
use App\Models\PropertyFacility;
use App\Models\PropertyAdditionalDetail;
use App\Models\PropertyPricing;
use App\Models\PropertyService;
use App\Models\Review;

/**
 * SearchController
 *
 * Responsibilities:
 *  - Build property search queries (filtering + sorting + pagination)
 *  - Build dynamic filter groups (counts computed from DB)
 *  - Return search results view and AJAX endpoints for live filtering
 *
 * Notes:
 *  - Counts are cached for short TTL (configurable inside class) to reduce DB load.
 *  - This controller expects the Property model relationships and table columns
 *    similar to the provided project schema.
 */
class SearchController extends Controller
{
    /**
     * Cache TTL (seconds) for filter counts
     */
    protected $cacheTtl = 60;

    /**
     * Default per-page result size
     */
    protected $perPage = 12;

    /**
     * Currency to display (for front-end)
     */
    protected $displayCurrency = 'USD';

    /**
     * Main search handler
     */
    public function search(Request $request)
    {
        if ($request->ajax()) {
        return $this->ajaxSearch($request);
    }
        // Lightweight validation for common fields
        $request->validate([
            'checkIn' => ['nullable', 'date'],
            'checkOut' => ['nullable', 'date', 'after_or_equal:checkIn'],
            'adults' => ['nullable', 'integer', 'min:0'],
            'children' => ['nullable', 'integer', 'min:0'],
            'rooms' => ['nullable', 'integer', 'min:1'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'property_rating' => ['nullable'],
        ]);

        $baseQuery = Property::query()
            ->where('status', 'active')
            ->where('open_for_bookings', 1)
            ->with(['files', 'facilities', 'rooms', 'pricing', 'additionalDetails', 'services'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        $this->applyRequestFilters($baseQuery, $request);
        $this->applySorting($baseQuery, $request->input('sort', null));

        $properties = $baseQuery->paginate($this->perPage)->appends($request->query());

        $filterGroups = $this->buildFilterGroups($request);
        $filterCounts = $this->buildCompactCounts($request);
        $searchData = $this->buildSearchDataFromRequest($request);
        $currency = $this->displayCurrency;
        $stars = $this->getDistinctStars();


        return view('Customer.search-results', compact('properties', 'filterGroups', 'filterCounts', 'searchData', 'currency','stars'));
    }

    /**
     * Apply all request filters to given query builder instance.
     */
    protected function applyRequestFilters(&$query, Request $request)
{
    // 1. Destination (Top Search Bar)
    if ($request->filled('destination') && !is_array($request->destination)) {
        $destination = trim($request->input('destination'));
        $query->where(function ($q) use ($destination) {
            $q->where('city', 'LIKE', "%{$destination}%")
              ->orWhere('country', 'LIKE', "%{$destination}%")
              ->orWhere('address', 'LIKE', "%{$destination}%")
              ->orWhere('title', 'LIKE', "%{$destination}%");
        });
    }

    // 2. Destination (Sidebar Checkboxes)
    if (is_array($request->input('destination'))) {
        $cities = array_filter($request->input('destination'));
        if (!empty($cities)) {
            $query->whereIn('city', $cities);
        }
    }

    // 3. Availability Dates
    if ($request->filled('checkIn') && $request->filled('checkOut')) {
        $checkIn  = $request->checkIn;
        $checkOut = $request->checkOut;

        $query->whereHas('rooms', function ($q) use ($checkIn, $checkOut) {
            $q->whereDoesntHave('bookings', function ($b) use ($checkIn, $checkOut) {
                $b->where('check_in', '<', $checkOut)
                  ->where('check_out', '>', $checkIn)
                  ->whereIn('status', ['pending', 'confirmed']);
            });
        });
    }

    // 4. Guests
    $adults = $request->input('adults');
    $children = $request->input('children');
    $totalGuests = (int)($adults ?: 0) + (int)($children ?: 0);
    if ($totalGuests > 0) {
        $query->whereHas('rooms', fn($r) => $r->where('max_guests', '>=', $totalGuests));
    }

    // 5. Room Count
    if ($request->filled('rooms')) {
        $roomsNeeded = max(1, (int)$request->rooms);
        $query->whereHas('rooms', function ($q) use ($roomsNeeded) {
            $q->select('property_id')->groupBy('property_id')->havingRaw('COUNT(id) >= ?', [$roomsNeeded]);
        });
    }

    // 6. Price Range Slider
    if ($request->filled('min_price') || $request->filled('max_price')) {
        $min = (float)($request->min_price ?: 0);
        $max = (float)($request->max_price ?: 999999);
        $query->where(function ($q) use ($min, $max) {
            $q->whereHas('pricing', fn($p) => $p->whereBetween('price_per_night', [$min, $max]))
              ->orWhereHas('rooms', fn($r) => $r->whereBetween('price_per_night', [$min, $max]));
        });
    }

    // 7. Property Rating (Stars)
    if ($request->filled('property_rating')) {
        $ratings = array_map('intval', (array)$request->property_rating);

        $query->whereIn(DB::raw('CAST(stars AS UNSIGNED)'), $ratings);
    }


    // 8. Amenities + Facilities
    foreach (['amenities', 'facilities'] as $filter) {
        if ($request->filled($filter)) {
            $values = (array)$request->input($filter);
            $query->whereHas('amenities', function ($a) use ($values) {
                $a->whereIn('amenities.name', $values);
            });
        }
    }

    // 9. Property Types (Category)
    if ($request->filled('property_types')) {
        $values = (array)$request->property_types;
        $query->whereHas('category', fn($c) => $c->whereIn('name', $values));
    }

    // 10. Property Subtypes (Subcategory)
    if ($request->filled('property_subtypes')) {
        $values = (array)$request->property_subtypes;
        $query->whereHas('subcategory', fn($s) => $s->whereIn('name', $values));
    }

    // 11. Policies (pets_allowed, etc.)
    if ($request->filled('policies')) {
        foreach ((array)$request->policies as $policy) {
            if ($policy === 'pets_allowed') {
                $query->whereHas('policies', fn($p) => $p->where('pets_allowed', 1));
            }
            if ($policy === 'smoking_allowed') {
                $query->whereHas('policies', fn($p) => $p->where('smoking_allowed', 1));
            }
            if ($policy === 'children_allowed') {
                $query->whereHas('policies', fn($p) => $p->where('children_allowed', 1));
            }
        }
    }

    // 12. Review Score
    if ($request->filled('min_score') && $request->min_score > 0) {
        $score = (float)$request->min_score;
        $query->whereHas('reviews', function ($r) use ($score) {
            $r->select('property_id')
              ->groupBy('property_id')
              ->havingRaw('AVG(rating) >= ?', [$score]);
        });
    }

    // 13. Price Buckets
    if ($request->filled('price_buckets')) {
        $buckets = (array)$request->input('price_buckets');
        $query->where(function ($q) use ($buckets) {
            foreach ($buckets as $bucket) {
                preg_match_all('/\d+/', $bucket, $matches);
                $nums = $matches[0] ?? [];
                if (count($nums) === 2) {
                    [$min, $max] = $nums;
                    $q->orWhere(function ($qq) use ($min, $max) {
                        $qq->whereHas('pricing', fn($p) => $p->whereBetween('price_per_night', [$min, $max]))
                           ->orWhereHas('rooms', fn($r) => $r->whereBetween('price_per_night', [$min, $max]));
                    });
                } elseif (count($nums) === 1) {
                    $min = $nums[0];
                    $q->orWhere(function ($qq) use ($min) {
                        $qq->whereHas('pricing', fn($p) => $p->where('price_per_night', '>=', $min))
                           ->orWhereHas('rooms', fn($r) => $r->where('price_per_night', '>=', $min));
                    });
                }
            }
        });
    }

    // 14. Keyword Search
    if ($request->filled('q')) {
        $q = trim($request->q);
        $query->where(function ($x) use ($q) {
            $x->where('title', 'LIKE', "%$q%")
              ->orWhere('description', 'LIKE', "%$q%");
        });
    }
}


    /**
     * Apply sorting to query
     */
   protected function applySorting(&$query, $sort = null)
{
    switch ($sort) {
        case 'price_low_high':
            $query->orderBy(
                DB::raw('(SELECT MIN(price_per_night)
                          FROM property_pricings
                          WHERE property_pricings.property_id = properties.id)'), 'asc'
            );
            break;

        case 'price_high_low':
            $query->orderBy(
                DB::raw('(SELECT MIN(price_per_night)
                          FROM property_pricings
                          WHERE property_pricings.property_id = properties.id)'), 'desc'
            );
            break;

        case 'rating_high_low':
            $query->orderByDesc(
                DB::raw('(SELECT AVG(rating)
                          FROM reviews
                          WHERE reviews.property_id = properties.id)')
            );
            break;

        case 'most_reviewed':
            $query->orderByDesc('reviews_count');
            break;

        default:
            $query->orderByDesc('created_at');
            break;
    }
}


    /**
     * Build the searchData array used to prefill frontend controls
     */
    protected function buildSearchDataFromRequest(Request $request): array
    {
        return [
            'destination' => $request->input('destination', ''),
            'checkIn' => $request->input('checkIn', ''),
            'checkOut' => $request->input('checkOut', ''),
            'adults' => (int)$request->input('adults', 2),
            'children' => (int)$request->input('children', 0),
            'rooms' => (int)$request->input('rooms', 1),
            'pets' => $request->boolean('pets', false),
            'q' => $request->input('q', ''),
            'min_price' => $request->input('min_price', null),
            'max_price' => $request->input('max_price', null),
        ];
    }

    /**
     * Build filter groups array dynamically from DB
     */
    protected function buildFilterGroups(Request $request): array
    {
        $templateGroups = [
            'popular' => ['Private bathroom', 'Free WiFi', 'Family rooms', 'Airport shuttle', 'Swimming Pool', 'Sauna'],
            'facilities' => $this->getAmenityNames(),
            'property_types' => $this->getPropertyCategoryNames(),
            'property_subtypes' => $this->getPropertySubcategoryNames(),
            'policies' => ['pets_allowed', 'smoking_allowed', 'children_allowed'],
            'destination' => $this->getTopCities(),
            'price_buckets' => $this->getPriceBuckets(),
        ];

        $filterGroups = [];

        // Pre-fetch property IDs (optimized for grouped counts)
        $filteredIds = Property::query()
            ->where('status', 'active')
            ->where('open_for_bookings', 1)
            ->when($request->filled('destination'), function ($q) use ($request) {
                $dest = $request->destination;
                $q->where('city', 'like', "%{$dest}%")->orWhere('country', 'like', "%{$dest}%");
            })
            ->pluck('id')
            ->toArray();

        // Bulk count maps
        $bulkAmenityCounts  = $this->bulkCountsForAmenities($templateGroups['facilities'], $filteredIds);
        $bulkCategoryCounts = $this->bulkCountsForCategories($templateGroups['property_types'], $filteredIds);
        $bulkCityCounts     = $this->bulkCountsForCities($templateGroups['destination'], $filteredIds);
        $bulkStarCounts     = $this->bulkCountsForStars($filteredIds);

        foreach ($templateGroups as $groupKey => $items) {
            switch ($groupKey) {
                case 'facilities':
                    $itemsWithCounts = $bulkAmenityCounts + array_fill_keys($items, 0);
                    break;
                case 'property_category':
                    $itemsWithCounts = $bulkCategoryCounts + array_fill_keys($items, 0);
                    break;
                case 'destination':
                    $itemsWithCounts = $bulkCityCounts + array_fill_keys($items, 0);
                    break;
                case 'stars':
                    $itemsWithCounts = [];
                    foreach ($items as $star) {
                        $itemsWithCounts[$star] = $bulkStarCounts[$star] ?? 0;
                    }
                    break;
                case 'popular':
                    $itemsWithCounts = [];
                    foreach ($items as $label) {
                        $itemsWithCounts[$label] = $bulkAmenityCounts[$label] ?? 0;
                    }
                    break;

                default:
                    $itemsWithCounts = [];
                    foreach ($items as $label) {
                        $cacheKey = "filter_count:{$groupKey}:" . md5($label) . ':' . md5(serialize($request->only(['destination', 'min_price', 'max_price', 'checkIn', 'checkOut', 'adults', 'children', 'rooms'])));
                        $itemsWithCounts[$label] = Cache::remember($cacheKey, $this->cacheTtl, function () use ($groupKey, $label, $request) {
                            return (int)$this->computeCountForFilter($groupKey, $label, $request);
                        });
                    }
                    break;
            }

            $filterGroups[] = [
                'title' => ucwords(str_replace('_', ' ', $groupKey)),
                'name' => $groupKey,
                'id_prefix' => str_replace('_', '-', $groupKey),
                'items' => $itemsWithCounts,
                'visible_count' => 6,
            ];
        }

        return $filterGroups;
    }

    /**
     * Optimized bulk count for stars (ratings)
     */
    protected function bulkCountsForStars($filteredIds)
    {
        if (empty($filteredIds)) {
            return array_fill_keys(range(1,5), 0);
        }

        $counts = DB::table('properties')
            ->whereIn('id', $filteredIds)
            ->whereNotNull('stars')
            ->select(DB::raw('CAST(stars AS UNSIGNED) as stars_numeric'), DB::raw('COUNT(*) as total'))
            ->groupBy('stars_numeric')
            ->pluck('total', 'stars_numeric')
            ->toArray();

        $full = [];
        foreach (range(1, 5) as $star) {
            $full[$star] = $counts[$star] ?? 0;
        }
        krsort($full);
        return $full;
    }

    /**
     * Build compact counts for a few common sidebar items
     */
    protected function buildCompactCounts(Request $request): array
    {
        $baseQuery = Property::query()->where('status', 'active');

        if ($request->filled('destination')) {
            $baseQuery->where(function ($q) use ($request) {
                $q->where('city', 'like', "%{$request->destination}%")
                  ->orWhere('country', 'like', "%{$request->destination}%");
            });
        }

        $counts = [
            'home' => (clone $baseQuery)->where('category_id', 1)->count(),
            'apartment' => (clone $baseQuery)->where('category_id', 2)->count(),
            'hotel_bnb' => (clone $baseQuery)->where('category_id', 3)->count(),
            'alternative' => (clone $baseQuery)->where('category_id', 4)->count(),
        ];

        return $counts;
    }

    /**
     * Compute count for a single filter label, given its group.
     */
    protected function computeCountForFilter(string $groupKey, string $label, Request $request): int
    {
        $baseQuery = Property::query()->where('status', 'active')->where('open_for_bookings', 1);

        if ($request->filled('destination')) {
            $dest = $request->input('destination');
            $baseQuery->where(function ($q) use ($dest) {
                $q->where('city', 'like', "%{$dest}%")->orWhere('country', 'like', "%{$dest}%");
            });
        }

        switch ($groupKey) {
            case 'amenities':
                return (clone $baseQuery)
                    ->whereHas('amenities', function ($q) use ($label) {
                        $q->where('amenities.name', $label);
                    })->count();

            // case 'facilities':
            //     return (clone $baseQuery)
            //         ->whereHas('facilities', function ($q) use ($label) {
            //             $q->where('facility_name', $label);
            //         })->count();

            case 'property_types':
                $category = PropertyCategory::where('name', $label)->first();
                if ($category) {
                    return (clone $baseQuery)->where('category_id', $category->id)->count();
                }
                return (clone $baseQuery)->where('group', $label)->count();

            case 'property_subtypes':
                $sub = PropertySubcategory::where('name', $label)->first();
                if ($sub) {
                    return (clone $baseQuery)->where('subcategory_id', $sub->id)->count();
                }
                return 0;

            case 'subtypes':
                $subtype = PropertySubtype::where('name', $label)->first();
                if ($subtype) {
                    return (clone $baseQuery)->where('subtype_id', $subtype->id)->count();
                }
                return 0;

            case 'stars':
                $normalized = preg_replace('/[^0-9]/', '', $label);
                if ($normalized === '') {
                    return 0;
                }
                return (clone $baseQuery)->where('stars', $normalized)->count();

            case 'destination':
                return (clone $baseQuery)->where('city', 'like', "%{$label}%")->count();

            case 'popular':
                return (clone $baseQuery)
                    ->whereHas('amenities', function ($q) use ($label) {
                        $q->where('amenities.name', $label);
                    })
                    ->count();

            case 'price_buckets':
                return $this->countPropertiesForPriceBucketLabel($label, $baseQuery);

            case 'policies':
                if ($label === 'pets_allowed') {
                    return (clone $baseQuery)->whereHas('policies', function ($q) {
                        $q->whereNotNull('pets_allowed')->where('pets_allowed', '!=', '');
                    })->count();
                } elseif ($label === 'smoking_allowed') {
                    return (clone $baseQuery)->whereHas('policies', function ($q) {
                        $q->where('smoking_allowed', 1);
                    })->count();
                } elseif ($label === 'children_allowed') {
                    return (clone $baseQuery)->whereHas('policies', function ($q) {
                        $q->where('children_allowed', 1);
                    })->count();
                }
                return 0;

            default:
                $c = (clone $baseQuery)->whereHas('facilities', function ($q) use ($label) {
                    $q->where('facility_name', $label);
                })->count();
                if ($c > 0) return $c;

                return (clone $baseQuery)->where('city', 'like', "%{$label}%")->count();
        }
    }

    /**
     * Helper to count properties in a given price-bucket label.
     */
    protected function countPropertiesForPriceBucketLabel(string $label, $baseQuery): int
    {
        $numbers = [];
        preg_match_all('/\d+/', $label, $numbers);
        $numbers = $numbers[0] ?? [];

        if (count($numbers) === 2) {
            $min = (float)$numbers[0];
            $max = (float)$numbers[1];
            return (clone $baseQuery)
                ->whereHas('pricing', function ($q) use ($min, $max) {
                    $q->whereBetween('price_per_night', [$min, $max]);
                })->orWhereHas('rooms', function ($q) use ($min, $max) {
                    $q->whereBetween('price_per_night', [$min, $max]);
                })->count();
        }

        if (count($numbers) === 1) {
            $min = (float)$numbers[0];
            return (clone $baseQuery)
                ->whereHas('pricing', function ($q) use ($min) {
                    $q->where('price_per_night', '>=', $min);
                })->orWhereHas('rooms', function ($q) use ($min) {
                    $q->where('price_per_night', '>=', $min);
                })->count();
        }

        return 0;
    }

    /**
     * Get amenity names (limit by popularity)
     */
    protected function getAmenityNames(): array
    {
        return Amenity::query()
            ->select('name')
            ->orderByDesc(DB::raw('(SELECT COUNT(*) FROM property_amenity pa WHERE pa.amenity_id = amenities.id)'))
            ->limit(30)
            ->pluck('name')
            ->toArray();
    }

    protected function getPropertyCategoryNames(): array
    {
        return PropertyCategory::query()
            ->orderBy('name')
            ->pluck('name')
            ->toArray();
    }

    protected function getPropertySubcategoryNames(): array
    {
        return PropertySubcategory::query()
            ->orderBy('name')
            ->pluck('name')
            ->toArray();
    }

    protected function getPropertySubtypeNames(): array
    {
        return PropertySubtype::query()
            ->orderBy('name')
            ->pluck('name')
            ->toArray();
    }

    protected function getDistinctStars(): array
{
    $results = DB::table('properties')
        ->select(
            DB::raw("CAST(REGEXP_REPLACE(stars, '[^0-9]', '') AS UNSIGNED) AS star"),
            DB::raw("COUNT(*) as count")
        )
        ->whereNotNull('stars')
        ->groupBy('star')
        ->pluck('count', 'star')
        ->toArray();

    // Always show 5 to 1 stars (Booking.com style)
    $stars = [];
    foreach (range(5, 1) as $star) {
        $stars[$star] = $results[$star] ?? 0;
    }

    return $stars;
}


    protected function getTopCities($limit = 25): array
    {
        return DB::table('properties')
            ->select('city', DB::raw('count(*) as total'))
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit($limit)
            ->pluck('city')
            ->toArray();
    }


    protected function getPriceBuckets(): array
    {
        return [
            'US$0 - US$50',
            'US$51 - US$100',
            'US$101 - US$150',
            'US$151 - US$200',
            'US$201 - US$300',
            'US$301 - US$500',
            'US$500+',
        ];
    }

    /**
     * AJAX endpoint to return rendered HTML for results
     */
 public function ajaxSearch(Request $request)
{
    \Log::info('AJAX FILTER INPUT', $request->all());

    // Build the base query
    $baseQuery = Property::query()
        ->with([
            'images',
            'pricing',
            'reviews',
            'rooms',
            'facilities',
            'policies',
        ])
        ->where('status', 'active');

    // Apply filters
    $this->applyRequestFilters($baseQuery, $request);

    // Debug SQL safely **AFTER baseQuery exists**
    \Log::info('FILTERED SQL', [
        'sql' => $baseQuery->toSql(),
        'bindings' => $baseQuery->getBindings()
    ]);

    // Fetch results
    $properties = $baseQuery->paginate(10);

    // Render results HTML partial
    $html = view('Customer._searchResults', compact('properties'))->render();

    return response()->json([
        'html' => $html,
        'count' => $properties->total(),
    ]);
}




    public function suggestCities(Request $request)
    {
        $term = trim($request->get('q', ''));
        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $cities = Property::query()
            ->select('city')
            ->where('status', 'active')
            ->whereNotNull('city')
            ->where('city', 'LIKE', "%{$term}%")
            ->distinct()
            ->orderBy('city')
            ->limit(10)
            ->pluck('city');

        $countries = Property::query()
            ->select('country')
            ->where('status', 'active')
            ->whereNotNull('country')
            ->where('country', 'LIKE', "%{$term}%")
            ->distinct()
            ->orderBy('country')
            ->limit(5)
            ->pluck('country');

        $suggestions = $cities->merge($countries)->unique()->values();

        return response()->json($suggestions);
    }

    public function fetchFilteredResults(Request $request)
    {
        $query = Property::with(['files', 'facilities', 'pricing'])
            ->where('status', 'active')
            ->where('open_for_bookings', 1);

        if ($request->filled('destination')) {
            $destination = $request->destination;
            $query->where(function ($q) use ($destination) {
                $q->where('city', 'like', "%{$destination}%")
                  ->orWhere('country', 'like', "%{$destination}%");
            });
        }

        if ($request->filled('budget')) {
            $budget = (float)$request->budget;
            $query->where(function ($q) use ($budget) {
                $q->whereHas('pricing', function ($q2) use ($budget) {
                    $q2->where('price_per_night', '<=', $budget);
                })->orWhereHas('rooms', function ($q2) use ($budget) {
                    $q2->where('price_per_night', '<=', $budget);
                });
            });
        }

        if ($request->filled('property_rating')) {
            $query->whereIn('star_rating', (array) $request->property_rating);
        }

        if ($request->filled('min_score') && $request->min_score > 0) {
            $minScore = (float)$request->min_score;
            $query->whereHas('reviews', function ($q) use ($minScore) {
                $q->select(DB::raw('property_id, AVG(rating) as avg_rating'))
                  ->groupBy('property_id')
                  ->havingRaw('AVG(rating) >= ?', [$minScore]);
            });
        }

        if ($request->filled('property_types')) {
            $types = explode(',', $request->property_type);
            $query->whereIn('property_types', $types);
        }

        $props = $query->paginate(10);

        $html = view('frontend.partials._searchResults', ['properties' => $props])->render();

        return response()->json(['html' => $html]);
    }

    public function filterCounts(Request $request)
    {
        $baseQuery = Property::query()->where('status', 'active')->where('open_for_bookings', 1);

        if ($request->filled('destination')) {
            $baseQuery->where(function ($q) use ($request) {
                $q->where('city', 'like', "%{$request->destination}%")
                  ->orWhere('country', 'like', "%{$request->destination}%");
            });
        }

        $counts = [
            'hotel' => (clone $baseQuery)->where('category_id', 3)->count(),
            'apartment' => (clone $baseQuery)->where('category_id', 2)->count(),
            'home' => (clone $baseQuery)->where('category_id', 1)->count(),
            'villa' => (clone $baseQuery)->whereHas('subtypes', function ($q) {
                $q->where('name', 'like', '%villa%');
            })->count(),
            'top_destinations' => $this->getTopCities(6),
        ];

        return response()->json($counts);
    }

    public function showSearchForm()
    {
        $cacheTtl = $this->cacheTtl;

        $cities = Cache::remember('search_form:cities', $cacheTtl, function () {
            return Property::whereNotNull('city')
                ->where('status', 'active')
                ->distinct()
                ->orderBy('city')
                ->pluck('city')
                ->toArray();
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

    public function debugFilterGroups(Request $request)
    {
        $groups = $this->buildFilterGroups($request);
        return response()->json($groups);
    }

    // Optimized bulk count fetchers
    protected function bulkCountsForAmenities(array $amenityNames, $filteredIds)
    {
        if (empty($amenityNames) || empty($filteredIds)) return [];

        return DB::table('property_amenity as pa')
            ->join('amenities as a', 'a.id', '=', 'pa.amenity_id')
            ->whereIn('pa.property_id', $filteredIds)
            ->whereIn('a.name', $amenityNames)
            ->select('a.name', DB::raw('COUNT(DISTINCT pa.property_id) as total'))
            ->groupBy('a.name')
            ->pluck('total', 'a.name')
            ->toArray();
    }

    

    protected function bulkCountsForCategories(array $catNames, $filteredIds)
    {
        if (empty($catNames) || empty($filteredIds)) return [];

        return DB::table('properties as p')
            ->join('property_categories as c', 'c.id', '=', 'p.category_id')
            ->whereIn('p.id', $filteredIds)
            ->whereIn('c.name', $catNames)
            ->select('c.name', DB::raw('COUNT(p.id) as total'))
            ->groupBy('c.name')
            ->pluck('total', 'c.name')
            ->toArray();
    }

    protected function bulkCountsForCities(array $cities, $filteredIds)
    {
        if (empty($cities) || empty($filteredIds)) return [];

        return DB::table('properties')
            ->whereIn('id', $filteredIds)
            ->whereIn('city', $cities)
            ->select('city', DB::raw('COUNT(*) as total'))
            ->groupBy('city')
            ->pluck('total', 'city')
            ->toArray();
    }
}
