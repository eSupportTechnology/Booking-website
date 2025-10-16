<?php

namespace App\Http\Controllers\Customer;

use App\Models\Car;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class CarSearchController extends Controller
{
    
    public function carsearch(Request $request)
    {
        // Start the base query
        $query = Car::where('status', 'Active')
            ->with('carType', 'company', 'brand', 'model');

        // Apply Dynamic Filtering based on Request inputs
        
        // --- START BOOKING FORM FILTERS (Captures data from the top search bar) ---
              if ($request->filled('pickup')) { 
            $pickup = $request->input('pickup');
            
        }
        if ($request->filled('destination')) { 
            $destination = $request->input('destination');
            
        }
        if ($request->filled('checkin')) { 
            $checkin = $request->input('checkin');
             
        }
        if ($request->filled('checkout')) { 
            $checkout = $request->input('checkout');
            
        }
        
        // --- START SIDEBAR FILTERS (Robust Implementation) ---
        
        // Filter by Car Category
        if ($request->filled('car_category')) {
            $categories = array_filter((array) $request->input('car_category')); // Filter out empty strings/nulls
            
            if (!empty($categories)) {
                // This assumes Car has a relationship 'carType' which has a 'name' field
                $query->whereHas('carType', function ($q) use ($categories) {
                    $q->whereIn('name', $categories);
                });
            }
        }
        
        // Filter by Transmission (assuming single select: radio button or single checkbox)
        if ($request->filled('transmission')) { 
            
            $query->where('transmission', $request->input('transmission')); 
        }
        
        // Filter by Supplier (Robust Example implementation)
        if ($request->filled('supplier')) {
            $suppliers = array_filter((array) $request->input('supplier')); // Filter out empty strings/nulls
            
            if (!empty($suppliers)) {
                $query->whereHas('company', function ($q) use ($suppliers) {
                    $q->whereIn('name', $suppliers);
                });
            }
        }
        
        // TODO: Implement remaining filters using request()->filled() for safety:
        
        // Get Filtered Cars and Paginate
        
        try {
             $filteredCars = $query->paginate(8)->appends($request->query());
        } catch (\Exception $e) {
             
             // log it and return an empty collection to prevent the 500 error from crashing the frontend.
             \Log::error("CarSearchController Query Error: " . $e->getMessage(), ['request' => $request->all()]);
             
             // Create an empty Paginator instance to prevent Blade errors
             $filteredCars = new \Illuminate\Pagination\LengthAwarePaginator(
                new \Illuminate\Support\Collection(), 0, 8, 1, ['path' => $request->url(), 'query' => $request->query()]
            );
        }

        
        // Prepare Filter Facets (Counts) - SIMULATED DATA
       
        $filterGroups = [
            'transmission' => ['Automatic' => 13, 'Manual' => 5],
            'supplier' => ['Europcar' => 13, 'Goodcar' => 10, 'Rent-A-Car' => 2],
            'mileage' => ['Unlimited' => 18, '1000 km' => 5],
            'extras' => ['GPS' => 10, 'Child seat' => 8, 'Additional driver' => 12],
            'seats' => ['4 seats' => 10, '5 seats' => 6, '6+ seats' => 5],
            'car_category' => ['Small car' => 7, 'Medium car' => 5, 'Large car' => 7, 'People carriers' => 4, 'SUVs' => 7],
            'price_range' => ['US$50 - US$100' => 6, 'US$100 - US$150' => 5, 'US$150 - US$200' => 3, 'US$200+' => 2],
            'payment'=> ['Pay Now' => 7, 'Pay at Pickup' => 0 ],
            'car-specs'=> ['Air Conditioning' => 10, '4+ Doors' => 5],
            'fuel-type'=> ['Petrol' => 10, 'Diesel' => 8, 'Electric' => 6, 'Hybrid' => 5],
            'deposit'=> ['US$0 - US$300' => 6, 'US$300 - US$600' => 5, 'US$600+' => 12],
            'fuel-policy'=> ['Like for like'=> 2],
            'review_score' => ['7+' => 13]
        ];

        // Prepare Category Tabs 
        $carCategoryTabs = ['Small car', 'Medium car', 'Large car', 'SUVs', 'People carrier'];
        
        // Pass data to the new view
        return view('Customer.car-rentals-filter', [
            'filteredCars' => $filteredCars,
            'filterGroups' => $filterGroups, 
            'currentFilters' => $request->query(), 
            'carCategoryTabs' => $carCategoryTabs,
        ]);
    }
}
