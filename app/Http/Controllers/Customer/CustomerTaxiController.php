<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Taxi;
use App\Models\TaxiType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class CustomerTaxiController extends Controller
{
    // List page (existing)
    public function index()
    {
        $activeTaxis = Taxi::whereRaw("LOWER(status) = 'active'")
            ->with(['type', 'drivers', 'fare'])
            ->paginate(8);

        return view('customer.airport-taxi-listing', compact('activeTaxis'));
    }

    // Latest taxis small widget (existing)
    public function showLatestTaxis()
    {
        $latestActiveTaxis = Taxi::whereRaw("LOWER(status) = 'active'")
            ->with(['type', 'drivers', 'fare'])
            ->latest()
            ->take(10)
            ->get();

        return view('frontend.airport-taxi', compact('latestActiveTaxis'));
    }

    // Single taxi page (existing)
    public function show($id)
    {
        $taxi = Taxi::whereRaw("LOWER(status) = 'active'")
            ->with(['type', 'drivers', 'fare'])
            ->findOrFail($id);

        return view('Customer.single-airport-taxi', compact('taxi'));
    }

    /**
     * Search / filter page (main)
     *
     * Supports:
     * - taxi_type[] (by name)
     * - passenger_capacity[] (exact numeric values or will be interpreted)
     * - luggage_capacity[] (exact numeric values)
     * - nearest_city[]
     * - pickup, destination (search nearest_city LIKE)
     * - passenger_range (tab clicks) with values like "1-4","5-8","9-12","13-20"
     */
    public function search(Request $request)
    {
        // Keep current filter selections to re-populate the form
        $currentFilters = [
            'taxi_type' => Arr::wrap($request->input('taxi_type', [])),
            'passenger_capacity' => Arr::wrap($request->input('passenger_capacity', [])),
            'luggage_capacity' => Arr::wrap($request->input('luggage_capacity', [])),
            'nearest_city' => Arr::wrap($request->input('nearest_city', [])),
            'pickup' => $request->input('pickup'),
            'destination' => $request->input('destination'),
            'checkin' => $request->input('checkin'),
            'passenger_range' => $request->input('passenger_range'),
        ];

        // Base query only active taxis
        $query = Taxi::query()->whereRaw("LOWER(status) = 'active'");

        // taxi_type filter (incoming names) -> convert to IDs
        if ($request->filled('taxi_type')) {
            $typeNames = Arr::wrap($request->input('taxi_type'));
            $typeIds = TaxiType::whereIn('name', $typeNames)->pluck('id')->toArray();
            if (!empty($typeIds)) {
                $query->whereIn('taxi_type_id', $typeIds);
            } else {
                // if names don't map, ensure no results rather than crash
                $query->whereRaw('0 = 1');
            }
        }

        // passenger_capacity exact values (checkboxes)
        if ($request->filled('passenger_capacity')) {
            $vals = array_map('intval', Arr::wrap($request->input('passenger_capacity')));
            $query->where(function ($q) use ($vals) {
                foreach ($vals as $v) {
                    // treat selected values as "minimum" seats acceptable
                    $q->orWhere('passenger_capacity', '>=', $v);
                }
            });
        }

        // luggage_capacity
        if ($request->filled('luggage_capacity')) {
            $vals = array_map('intval', Arr::wrap($request->input('luggage_capacity')));
            $query->where(function ($q) use ($vals) {
                foreach ($vals as $v) {
                    $q->orWhere('luggage_capacity', '>=', $v);
                }
            });
        }

        // passenger_range (tabs)
        if ($request->filled('passenger_range')) {

            $ranges = Arr::wrap($request->input('passenger_range'));

            $query->where(function ($q) use ($ranges) {

                foreach ($ranges as $range) {

                    if (preg_match('/^(\d+)-(\d+)$/', $range, $m)) {
                        $min = (int)$m[1];
                        $max = (int)$m[2];

                        $q->orWhereBetween('passenger_capacity', [$min, $max]);

                    } elseif ($range === '13+' || $range === '13-20') {
                        $q->orWhere('passenger_capacity', '>=', 13);
                    }
                }
            });
        }


        // nearest_city exact matches
        if ($request->filled('nearest_city')) {
            $query->whereIn('nearest_city', Arr::wrap($request->input('nearest_city')));
        }

        // pickup/destination: match nearest_city LIKE
        if ($request->filled('pickup')) {
            $pickup = $request->input('pickup');
            $query->where('nearest_city', 'like', "%{$pickup}%");
        }
        

        // Eager load type and fare
        $filteredTaxis = $query->with(['type', 'fare'])->paginate(12)->appends($request->query());

        // Filter groups for sidebar (counts)
        $filterGroups = $this->buildFilterGroups();
        

        // Build dynamic tabs:
        // We'll generate passenger-range tabs if there are taxis in those ranges
        $allActiveTaxis = Taxi::whereRaw("LOWER(status) = 'active'")->get(['passenger_capacity', 'taxi_type_id']);
        $passengerTabs = [];
        if ($allActiveTaxis->where('passenger_capacity', '<=', 4)->count() > 0) {
            $passengerTabs[] = ['label' => '1 - 4 passengers', 'value' => '1-4'];
        }
        if ($allActiveTaxis->where('passenger_capacity', '>=', 5)->where('passenger_capacity', '<=', 8)->count() > 0) {
            $passengerTabs[] = ['label' => '5 - 8 passengers', 'value' => '5-8'];
        }
        if ($allActiveTaxis->where('passenger_capacity', '>=', 9)->where('passenger_capacity', '<=', 12)->count() > 0) {
            $passengerTabs[] = ['label' => '9 - 12 passengers', 'value' => '9-12'];
        }
        if ($allActiveTaxis->where('passenger_capacity', '>=', 13)->count() > 0) {
            $passengerTabs[] = ['label' => '13 - 20 passengers', 'value' => '13+'];
        }
       

        // final tabs: passenger ranges first, then taxi types (keeps order predictable)
        $taxiCategoryTabs = array_merge($passengerTabs);

        return view('airport_taxis.airport-taxi-search', compact(
            'filteredTaxis',
            'filterGroups',
            'currentFilters',
            'taxiCategoryTabs'
        ));
    }

    // JSON counts (AJAX helper if needed)
    public function filterCounts()
    {
        return response()->json($this->buildFilterGroups());
    }

    // Build filter groups with counts (taxi_type => count, passenger_capacity => count, etc.)
    private function buildFilterGroups()
{
    // Step 1: load all TaxiTypes
    $types = TaxiType::orderBy('id')->get();

    // Step 2: get counts for types that HAVE taxis (active only)
    $activeCounts = Taxi::with('type')
        ->selectRaw('taxi_type_id, COUNT(*) as total')
        ->whereRaw("LOWER(status) = 'active'")
        ->groupBy('taxi_type_id')
        ->get()
        ->mapWithKeys(function ($item) {
            return [$item->type->name => $item->total];
        })
        ->toArray();

    // Step 3: fill missing types with 0
    $taxiTypeCounts = [];
    foreach ($types as $type) {
        $taxiTypeCounts[$type->name] = $activeCounts[$type->name] ?? 0;
    }


    // PASSENGER EXACT COUNTS
    $passengerCounts = Taxi::select('passenger_capacity', DB::raw('count(*) as cnt'))
        ->whereNotNull('passenger_capacity')
        ->whereRaw("LOWER(status) = 'active'")
        ->groupBy('passenger_capacity')
        ->pluck('cnt', 'passenger_capacity')
        ->toArray();

    // LUGGAGE
    $luggageCounts = Taxi::select('luggage_capacity', DB::raw('count(*) as cnt'))
        ->whereNotNull('luggage_capacity')
        ->whereRaw("LOWER(status) = 'active'")
        ->groupBy('luggage_capacity')
        ->pluck('cnt', 'luggage_capacity')
        ->toArray();

    // CITIES
    $cityCounts = Taxi::select('nearest_city', DB::raw('count(*) as cnt'))
        ->whereNotNull('nearest_city')
        ->whereRaw("LOWER(status) = 'active'")
        ->groupBy('nearest_city')
        ->pluck('cnt', 'nearest_city')
        ->toArray();

    return [
        'taxi_type' => $taxiTypeCounts,
        'passenger_capacity' => $passengerCounts,
        'luggage_capacity' => $luggageCounts,
        'nearest_city' => $cityCounts,
    ];
}

}
