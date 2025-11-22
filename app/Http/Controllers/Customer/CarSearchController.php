<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Car;
use App\Models\CarType;
use App\Models\Company;

class CarSearchController extends Controller
{
    public function carsearch(Request $request)
    {
        // BASE QUERY (only Active cars)
        $baseQuery = Car::query()
            ->where('status', 'Active')
            ->with(['carType', 'company', 'brand', 'model']);

        // Apply filters for the main results
        $resultsQuery = $this->applyFilters(clone $baseQuery, $request);

        // Paginate results
        $filteredCars = $resultsQuery
            ->paginate(8)
            ->appends($request->query());

        // ===== DYNAMIC FACETS =====
        $filterGroups = [
            'transmission' => $this->facetCounts($baseQuery, $request, 'transmission'),
            'supplier'     => $this->facetSupplierCounts($baseQuery, $request),
            'mileage'      => $this->facetCounts($baseQuery, $request, 'mileage_type'),
            'extras'       => [], // no extras table
            'seats'        => $this->facetSeatsCounts($baseQuery, $request),
            'nearest_city' => $this->facetNearestCityCounts($baseQuery, $request),
            'car_category' => $this->facetCarCategoryCounts($baseQuery, $request),
            'price_range'  => $this->facetPriceRanges($baseQuery, $request),
            'payment'      => $this->facetCounts($baseQuery, $request, 'pay_timing'),
            'car-specs'    => [], // not available
            'fuel_type' => $this->facetCounts($baseQuery, $request, 'fuel_type'),
            'deposit'      => $this->facetDepositRanges($baseQuery, $request),
            'fuel-policy'  => [],
            'review_score' => $this->facetReviewScores($baseQuery, $request),
        ];

        // Car category tabs (dynamic)
        $carCategoryTabs = CarType::pluck('name')->toArray();

        return view('Customer.car-rentals-filter', [
            'filteredCars'   => $filteredCars,
            'filterGroups'   => $filterGroups,
            'currentFilters' => $request->query(),
            'carCategoryTabs' => $carCategoryTabs,
        ]);
    }

    // ================================================================
    // APPLY FILTERS (ALL DYNAMIC)
    // ================================================================
    protected function applyFilters($query, Request $request, $exclude = null)
    {
        // nearest_city = pickup
        if ($exclude !== 'pickup' && $request->filled('pickup')) {
            $query->where('nearest_city', $request->pickup);
        }

        // Transmission
        if ($exclude !== 'transmission' && $request->filled('transmission')) {
            $query->where('transmission', strtolower($request->transmission));
        }

        // Supplier (company name)
        if ($exclude !== 'supplier' && $request->filled('supplier')) {
            $companyIds = Company::whereIn('name', (array)$request->supplier)->pluck('id');
            $query->whereIn('company_id', $companyIds);
        }

        // Car Category (car type)
        if ($exclude !== 'car_category' && $request->filled('car_category')) {
            $typeIds = CarType::whereIn('name', (array)$request->car_category)->pluck('id');
            $query->whereIn('car_type_id', $typeIds);
        }

        // Fuel type
        if ($exclude !== 'fuel_type' && $request->filled('fuel_type')) {
            $query->whereIn('fuel_type', (array)$request->fuel_type);
        }

        // Mileage type
        if ($exclude !== 'mileage_type' && $request->filled('mileage_type')) {
            $query->whereIn('mileage_type', (array)$request->mileage_type);
        }

        // Seats
        if ($exclude !== 'seats' && $request->filled('seats')) {
            $seatValues = array_map(function ($s) {
                return (int)filter_var($s, FILTER_SANITIZE_NUMBER_INT);
            }, (array)$request->seats);

            $query->whereIn('seats', $seatValues);
        }

        // Pay timing
        if ($exclude !== 'pay_timing' && $request->filled('pay_timing')) {
            $query->whereIn('pay_timing', (array)$request->pay_timing);
        }

        // Price
        if ($exclude !== 'price_range') {
            if ($request->filled('price_min'))
                $query->where('price_per_day', '>=', $request->price_min);

            if ($request->filled('price_max'))
                $query->where('price_per_day', '<=', $request->price_max);
        }

        // Deposit
        if ($exclude !== 'deposit') {
            if ($request->filled('deposit_min'))
                $query->where('deposit', '>=', $request->deposit_min);

            if ($request->filled('deposit_max'))
                $query->where('deposit', '<=', $request->deposit_max);
        }

        if ($exclude !== 'nearest_city' && $request->filled('nearest_city')) {
            $query->whereIn('nearest_city', (array)$request->nearest_city);
        }


        return $query;
    }

    // ================================================================
    // GENERIC FACET COUNTS
    // ================================================================
    protected function facetCounts($query, Request $request, $column)
    {
        $q = $this->applyFilters(clone $query, $request, $column);

        return $q->select($column, DB::raw('COUNT(*) as cnt'))
            ->groupBy($column)
            ->pluck('cnt', $column)
            ->toArray();
    }

    // ================================================================
    // SUPPLIER COUNTS
    // ================================================================
    protected function facetSupplierCounts($query, Request $request)
    {
        $q = $this->applyFilters(clone $query, $request, 'supplier');

        $rows = $q->select('company_id', DB::raw('COUNT(*) as cnt'))
            ->groupBy('company_id')
            ->get();

        $companyNames = Company::whereIn('id', $rows->pluck('company_id'))
            ->pluck('name', 'id');

        $output = [];
        foreach ($rows as $row) {
            $output[$companyNames[$row->company_id] ?? 'Unknown'] = $row->cnt;
        }

        return $output;
    }

    // ================================================================
    // CAR CATEGORY COUNTS
    // ================================================================
    protected function facetCarCategoryCounts($query, Request $request)
    {
        $q = $this->applyFilters(clone $query, $request, 'car_category');

        $rows = $q->select('car_type_id', DB::raw('COUNT(*) as cnt'))
            ->groupBy('car_type_id')
            ->get();

        $names = CarType::whereIn('id', $rows->pluck('car_type_id'))
            ->pluck('name', 'id');

        $output = [];
        foreach ($rows as $row) {
            $output[$names[$row->car_type_id]] = $row->cnt;
        }

        return $output;
    }

    // ================================================================
    // SEAT COUNTS
    // ================================================================
    protected function facetSeatsCounts($query, Request $request)
    {
        $q = $this->applyFilters(clone $query, $request, 'seats');

        $rows = $q->select('seats', DB::raw('COUNT(*) AS cnt'))
            ->groupBy('seats')
            ->pluck('cnt', 'seats')
            ->toArray();

        return [
            '4 seats' => $rows[4] ?? 0,
            '5 seats' => $rows[5] ?? 0,
            '6 seats' => $rows[6] ?? 0,
            '7+ seats' => array_sum(array_filter($rows, fn($v, $k) => $k >= 7, ARRAY_FILTER_USE_BOTH)),
        ];
    }

    // ================================================================
    // PRICE RANGE COUNTS
    // ================================================================
    protected function facetPriceRanges($query, Request $request)
    {
        $ranges = [
            'US$0 - US$100'   => [0, 100],
            'US$100 - US$200' => [100.01, 200],
            'US$200+'         => [200.01, 999999],
        ];

        $output = [];
        foreach ($ranges as $label => [$min, $max]) {
            $count = $this->applyFilters(clone $query, $request, 'price_range')
                ->whereBetween('price_per_day', [$min, $max])
                ->count();
            $output[$label] = $count;
        }

        return $output;
    }

    // ================================================================
    // DEPOSIT RANGE COUNTS
    // ================================================================
    protected function facetDepositRanges($query, Request $request)
    {
        $ranges = [
            'US$0 - US$300' => [0, 300],
            'US$300 - US$600' => [300.01, 600],
            'US$600+' => [600.01, 999999],
        ];

        $output = [];
        foreach ($ranges as $label => [$min, $max]) {
            $count = $this->applyFilters(clone $query, $request, 'deposit')
                ->whereBetween('deposit', [$min, $max])
                ->count();
            $output[$label] = $count;
        }

        return $output;
    }

    // ================================================================
    // Nearest City COUNTS
    // ================================================================
    protected function facetNearestCityCounts($query, Request $request)
{
    $q = $this->applyFilters(clone $query, $request, 'nearest_city');

    return $q->select('nearest_city', DB::raw('COUNT(*) as cnt'))
            ->whereNotNull('nearest_city')
            ->groupBy('nearest_city')
            ->pluck('cnt', 'nearest_city')
            ->toArray();
}

    // ================================================================
    // COMPANY RATING / REVIEW SCORE COUNTS
    // ================================================================
    protected function facetReviewScores($query, Request $request)
    {
        $q = $this->applyFilters(clone $query, $request, 'review_score')
            ->join('companies', 'cars.company_id', '=', 'companies.id');

        $rows = $q->select(
            DB::raw('
                CASE 
                    WHEN rating >= 4.5 THEN "4.5+"
                    WHEN rating >= 4.0 THEN "4.0 - 4.49"
                    ELSE "<4.0"
                END AS bucket
            '),
            DB::raw('COUNT(*) AS cnt')
        )
        ->groupBy('bucket')
        ->pluck('cnt', 'bucket')
        ->toArray();

        return [
            '4.5+' => $rows['4.5+'] ?? 0,
            '4.0 - 4.49' => $rows['4.0 - 4.49'] ?? 0,
            '<4.0' => $rows['<4.0'] ?? 0,
        ];
    }

    public function locationSuggest(Request $request)
{
    $q = $request->q;

    if (!$q || strlen($q) < 1) {
        return [];
    }

    return Car::whereNotNull('nearest_city')
        ->where('nearest_city', 'like', "%{$q}%")
        ->distinct()
        ->limit(10)
        ->pluck('nearest_city');
}


    public function show($id)
{
    $car = Car::where('id', $id)
        ->where('status', 'Active')
        ->with(['carType', 'company', 'model', 'brand'])
        ->firstOrFail();

    return view('car_rentals.car-details', [
    'car' => $car,
    // add other variables if needed
]);

}

}
