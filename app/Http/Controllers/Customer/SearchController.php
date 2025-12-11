<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Property;
use App\Models\Amenity;
use App\Models\PropertyCategory;
use App\Models\PropertySubcategory;
use App\Models\PropertyPricing;
use App\Models\Review;
use Illuminate\Support\Carbon;

class SearchController extends Controller
{
    protected $perPage = 12;
    protected $cacheTtl = 60;

    public function search(Request $request)
{
    // ---- SAVE ALL SEARCH INPUTS ----
    $searchData = [
        'destination' => $request->destination,
        'checkIn'     => $request->checkIn,
        'checkOut'    => $request->checkOut,
        'adults'      => $request->adults,
        'children'    => $request->children,
        'rooms'       => $request->rooms,
        'pets'        => $request->pets,
    ];

    // ---- BASE QUERY ----
    $baseQuery = Property::query()
        ->where('status', 'active')
        ->where('open_for_bookings', 1);

    // ---- TOP SEARCH: Destination ----
    if ($request->filled('destination')) {
        $dest = trim($request->destination);
        $baseQuery->where(function($q) use ($dest) {
            $q->where('city', 'like', "%{$dest}%")
              ->orWhere('country', 'like', "%{$dest}%")
              ->orWhere('title', 'like', "%{$dest}%")
              ->orWhere('address', 'like', "%{$dest}%");
        });
    }

    // ---- FETCH BASE FILTERED IDS (for counts) ----
    $filteredIds = (clone $baseQuery)->pluck('id')->toArray();

    // ---- BUILD FILTER GROUPS ----
    $filterGroups = $this->buildFilterGroups($filteredIds);

    // ---- RESULTS QUERY ----
    $resultsQuery = Property::query()
        ->where('status', 'active')
        ->where('open_for_bookings', 1);

    // Apply all filters including price, amenities, stars, etc
    $this->applyFiltersToQuery($resultsQuery, $request);

    // ---- IMPORTANT: CHECK-IN + CHECK-OUT FILTER (Date Availability) ----
    // CHECK DATE AVAILABILITY AGAINST BOOKINGS TABLE
    if ($request->filled('checkIn') && $request->filled('checkOut')) {

        $checkIn  = Carbon::parse($request->checkIn)->format('Y-m-d');
        $checkOut = Carbon::parse($request->checkOut)->format('Y-m-d');

        $resultsQuery->whereDoesntHave('bookings', function ($booking) use ($checkIn, $checkOut) {
            $booking->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
        });
    }


    // ---- GUESTS FILTER (if minimum capacity required) ----
    if ($request->filled('adults')) {
        $resultsQuery->whereHas('additionalDetails', function($d) use ($request) {
            $d->where('guests', '>=', (int)$request->adults);
        });
    }

    // ---- PETS FILTER ----
    if ($request->pets == 1) {
        $resultsQuery->whereHas('policies', function($p) {
            $p->where('pets_allowed', 1);
        });
    }

    // ---- LOAD RELATIONSHIPS ----
    $resultsQuery->with([
        'files',
        'pricing',
        'additionalDetails',
        'policies',
        'services'
    ]);

    // ---- SORTING ----
    if ($request->filled('sort')) {
        switch ($request->sort) {
            case 'price_low_high':
                $resultsQuery->orderBy(
                    DB::raw('(SELECT MIN(price_per_night) FROM property_pricings WHERE property_pricings.property_id = properties.id)'),
                    'asc'
                );
                break;

            case 'price_high_low':
                $resultsQuery->orderBy(
                    DB::raw('(SELECT MIN(price_per_night) FROM property_pricings WHERE property_pricings.property_id = properties.id)'),
                    'desc'
                );
                break;

            case 'rating_high_low':
                $resultsQuery->orderByDesc(
                    DB::raw('(SELECT AVG(rating) FROM reviews WHERE reviews.property_id = properties.id)')
                );
                break;

            default:
                $resultsQuery->orderByDesc('created_at');
        }
    } else {
        $resultsQuery->orderByDesc('created_at');
    }

    // ---- PAGINATION ----
    $properties = $resultsQuery
        ->paginate($this->perPage)
        ->appends($request->query());

    // ---- SEND EVERYTHING TO VIEW ----
    return view('Customer.search-results', [
        'properties'     => $properties,
        'filterGroups'   => $filterGroups,
        'filteredIds'    => $filteredIds,
        'currentFilters' => $request->all(),
        'searchData'     => $searchData,  // 🔥 NOW PASSED TO VIEW
    ]);
}

    protected function applyFiltersToQuery(&$q, Request $request)
{
    // Destination (top search)
    if ($request->filled('destination')) {
        $dest = trim($request->destination);
        $q->where(function($x) use ($dest) {
            $x->where('city', 'like', "%{$dest}%")
              ->orWhere('country', 'like', "%{$dest}%")
              ->orWhere('title', 'like', "%{$dest}%")
              ->orWhere('address', 'like', "%{$dest}%");
        });
    }

    // Destination (city checkboxes)
    if ($request->filled('cities')) {
        $q->whereIn('city', (array)$request->cities);
    }

    // Categories
    if ($request->filled('property_types')) {
        $catNames = (array)$request->property_types;
        $catIds = PropertyCategory::whereIn('name', $catNames)->pluck('id');
        if ($catIds->count()) {
            $q->whereIn('category_id', $catIds);
        }
    }

    // Subcategories
    if ($request->filled('property_subtypes')) {
        $subNames = (array)$request->property_subtypes;
        $subIds = PropertySubcategory::whereIn('name', $subNames)->pluck('id');
        if ($subIds->count()) {
            $q->whereIn('subcategory_id', $subIds);
        }
    }

    // Stars
    if ($request->filled('stars')) {
        $stars = array_map(fn($s) => (int)preg_replace('/[^0-9]/','',$s), (array)$request->stars);
        $q->whereIn(DB::raw("CAST(stars AS UNSIGNED)"), $stars);
    }

    // Price range (THIS WAS BROKEN — FIXED)
    if ($request->filled('min_price') || $request->filled('max_price')) {
        $min = $request->min_price ?? 0;
        $max = $request->max_price ?? 999999;

        $q->where(function($group) use ($min, $max) {
            $group->whereHas('pricing', fn($p) => $p->whereBetween('price_per_night', [$min, $max]))
                  ->orWhereHas('rooms', fn($r) => $r->whereBetween('price_per_night', [$min, $max]));
        });
    }

    // Amenities
    if ($request->filled('amenities')) {
        $values = (array)$request->amenities;
        $q->whereHas('amenities', function($a) use ($values) {
            $a->whereIn('amenities.name', $values);
        });
    }

    // Policies
    if ($request->filled('policies')) {
        foreach ((array)$request->policies as $policy) {
            if ($policy === 'pets_allowed') {
                $q->whereHas('policies', fn($p) => $p->where('pets_allowed','!=',''));
            }
            if ($policy === 'smoking_allowed') {
                $q->whereHas('policies', fn($p) => $p->where('smoking_allowed',1));
            }
            if ($policy === 'children_allowed') {
                $q->whereHas('policies', fn($p) => $p->where('children_allowed',1));
            }
        }
    }

    // Review score
    if ($request->filled('min_score')) {
        $min = (float)$request->min_score;
        $q->whereHas('reviews', function($r) use ($min) {
            $r->select('property_id')
              ->groupBy('property_id')
              ->havingRaw('AVG(rating) >= ?', [$min]);
        });
    }
}


    /**
     * Build filter groups (amenities, categories, cities, price buckets, stars, review buckets, policies, services)
     * $filteredIds - property ids already limited by text/destination input
     */
    protected function buildFilterGroups(array $filteredIds = [])
    {
        // Amenity list (top 30)
        $amenities = Amenity::select('name','category')
            ->orderBy('name')
            ->limit(50)
            ->get()
            ->pluck('name','name')
            ->toArray();

        // categories & subcategories
        $categories = PropertyCategory::orderBy('name')->pluck('name','name')->toArray();
        $subcategories = PropertySubcategory::orderBy('name')->pluck('name','name')->toArray();

        // cities (top 25)
        $cities = DB::table('properties')->select('city', DB::raw('COUNT(*) as total'))
            ->whereNotNull('city')->where('city','!=','')
            ->groupBy('city')->orderByDesc('total')->limit(25)->pluck('city')->toArray();

        // price buckets (static)
        $priceBuckets = [
            'US$0 - US$50',
            'US$51 - US$100',
            'US$101 - US$150',
            'US$151 - US$200',
            'US$201 - US$300',
            'US$301 - US$500',
            'US$500+',
        ];

        // stars distinct values from properties (normalize to 1..5)
        $starsRaw = DB::table('properties')->select(DB::raw("CAST(REGEXP_REPLACE(stars,'[^0-9]','') AS UNSIGNED) as s"), DB::raw('COUNT(*) as total'))
            ->whereNotNull('stars')->groupBy('s')->pluck('total','s')->toArray();

        $stars = [];
        foreach(range(5,1) as $st) {
            $stars[$st . ' stars'] = $starsRaw[$st] ?? 0;
        }

        // review buckets (9+, 8+, 7+, Any)
        $reviewBuckets = [
            '9+' => $this->countPropertiesWithAvgRatingAtLeast(9, $filteredIds),
            '8+' => $this->countPropertiesWithAvgRatingAtLeast(8, $filteredIds),
            '7+' => $this->countPropertiesWithAvgRatingAtLeast(7, $filteredIds),
            'Any' => count($filteredIds) ? count($filteredIds) : (int)Property::where('status','active')->count()
        ];

        // policies counts
        $policies = [
            'pets_allowed' => $this->countPropertiesWithPolicy('pets_allowed', $filteredIds),
            'smoking_allowed' => $this->countPropertiesWithPolicy('smoking_allowed', $filteredIds),
            'children_allowed' => $this->countPropertiesWithPolicy('children_allowed', $filteredIds),
        ];

        // price bucket counts (bulk)
        $priceCounts = $this->bulkCountsForPriceBuckets($filteredIds, $priceBuckets);

        // amenity counts (bulk)
        $amenityCounts = $this->bulkCountsForAmenities(array_values($amenities), $filteredIds);

        // category counts
        $categoryCounts = $this->bulkCountsForCategories(array_values($categories), $filteredIds);

        // city counts
        $cityCounts = $this->bulkCountsForCities($cities, $filteredIds);

        // package into groups
        $groups = [];

        $groups[] = [
            'title' => 'Amenities',
            'name' => 'amenities',
            'id_prefix' => 'amenities',
            'items' => $this->mapCountsToLabels($amenityCounts, array_values($amenities)),
            'visible_count' => 6
        ];

        $groups[] = [
            'title' => 'Property Types',
            'name' => 'property_types',
            'id_prefix' => 'property-types',
            'items' => $this->mapCountsToLabels($categoryCounts, array_values($categories)),
            'visible_count' => 8
        ];

        $groups[] = [
            'title' => 'Property Subtypes',
            'name' => 'property_subtypes',
            'id_prefix' => 'property-subtypes',
            'items' => array_fill_keys(array_values($subcategories), 0),
            'visible_count' => 6
        ];

        $groups[] = [
            'title' => 'Destination',
            'name' => 'cities',
            'id_prefix' => 'cities',
            'items' => $this->mapCountsToLabels($cityCounts, $cities),
            'visible_count' => 6
        ];

        $groups[] = [
            'title' => 'Price Buckets',
            'name' => 'price_buckets',
            'id_prefix' => 'price-buckets',
            'items' => $this->mapCountsToLabels($priceCounts, $priceBuckets),
            'visible_count' => 6
        ];

        $groups[] = [
            'title' => 'Stars',
            'name' => 'stars',
            'id_prefix' => 'stars',
            'items' => $this->mapCountsToLabels($stars, array_keys($stars)),
            'visible_count' => 6
        ];

        $groups[] = [
            'title' => 'Review Score',
            'name' => 'review_score',
            'id_prefix' => 'review-score',
            'items' => $reviewBuckets,
            'visible_count' => 6
        ];

        $groups[] = [
            'title' => 'Policies',
            'name' => 'policies',
            'id_prefix' => 'policies',
            'items' => $policies,
            'visible_count' => 6
        ];

        return $groups;
    }

    protected function mapCountsToLabels($counts, $labels)
    {
        $out = [];
        foreach($labels as $label) {
            $out[$label] = $counts[$label] ?? 0;
        }
        return $out;
    }

    protected function bulkCountsForAmenities(array $amenityNames, array $filteredIds)
    {
        if (empty($amenityNames)) return [];

        $q = DB::table('property_amenity as pa')
            ->join('amenities as a', 'a.id', '=', 'pa.amenity_id');

        if (!empty($filteredIds)) {
            $q->whereIn('pa.property_id', $filteredIds);
        }

        $q->whereIn('a.name', $amenityNames)
            ->select('a.name', DB::raw('COUNT(DISTINCT pa.property_id) as total'))
            ->groupBy('a.name');

        return $q->pluck('total', 'name')->toArray();
    }

    protected function bulkCountsForCategories(array $catNames, array $filteredIds)
    {
        if (empty($catNames)) return [];
        $q = DB::table('properties as p')
            ->join('property_categories as c', 'c.id', '=', 'p.category_id')
            ->whereIn('c.name', $catNames);

        if (!empty($filteredIds)) $q->whereIn('p.id', $filteredIds);

        $q->select('c.name', DB::raw('COUNT(p.id) as total'))
          ->groupBy('c.name');

        return $q->pluck('total', 'name')->toArray();
    }

    protected function bulkCountsForCities(array $cities, array $filteredIds)
    {
        if (empty($cities)) return [];
        $q = DB::table('properties')->whereIn('city', $cities);

        if (!empty($filteredIds)) $q->whereIn('id', $filteredIds);

        return $q->select('city', DB::raw('COUNT(*) as total'))->groupBy('city')->pluck('total','city')->toArray();
    }

    protected function bulkCountsForPriceBuckets(array $filteredIds, array $buckets)
    {
        // buckets: parse numeric ranges
        $out = [];
        foreach ($buckets as $bucket) {
            preg_match_all('/\d+/', $bucket, $m);
            $nums = $m[0] ?? [];
            if (count($nums) === 2) {
                $min = (float)$nums[0];
                $max = (float)$nums[1];
                $count = (clone Property::query())
                    ->when(!empty($filteredIds), fn($q) => $q->whereIn('id', $filteredIds))
                    ->whereHas('pricing', fn($q2) => $q2->whereBetween('price_per_night', [$min, $max]))
                    ->orWhereHas('rooms', fn($r) => $r->whereBetween('price_per_night', [$min, $max]))
                    ->count();
            } elseif (count($nums) === 1) {
                $min = (float)$nums[0];
                $count = (clone Property::query())
                    ->when(!empty($filteredIds), fn($q) => $q->whereIn('id', $filteredIds))
                    ->whereHas('pricing', fn($q2) => $q2->where('price_per_night', '>=', $min))
                    ->orWhereHas('rooms', fn($r) => $r->where('price_per_night', '>=', $min))
                    ->count();
            } else {
                $count = 0;
            }
            $out[$bucket] = $count;
        }
        return $out;
    }

    protected function countPropertiesWithAvgRatingAtLeast($rating, $filteredIds = [])
    {
        $q = DB::table('reviews')
            ->select('property_id', DB::raw('AVG(rating) as avg_rating'))
            ->groupBy('property_id')
            ->havingRaw('AVG(rating) >= ?', [$rating]);

        if (!empty($filteredIds)) {
            $q->whereIn('property_id', $filteredIds);
        }

        return $q->count();
    }

    protected function countPropertiesWithPolicy($policyName, $filteredIds = [])
    {
        $q = DB::table('property_policies')->where($policyName, '!=', 0)->whereNotNull($policyName);
        if (!empty($filteredIds)) $q->whereIn('property_id', $filteredIds);
        return $q->count();
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

}
