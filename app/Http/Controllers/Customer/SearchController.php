<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = Property::query();

        // Filter by destination if provided
        if ($request->filled('destination')) {
            $query->where(function($q) use ($request) {
                $q->where('city', 'LIKE', '%' . $request->destination . '%')
                  ->orWhere('country', 'LIKE', '%' . $request->destination . '%')
                  ->orWhere('address', 'LIKE', '%' . $request->destination . '%');
            });
        }

        // Filter by dates if provided
        if ($request->filled('checkIn') && $request->filled('checkOut')) {
            $query->whereDoesntHave('bookings', function($q) use ($request) {
                $q->where(function($q) use ($request) {
                    $q->whereBetween('check_in', [$request->checkIn, $request->checkOut])
                      ->orWhereBetween('check_out', [$request->checkIn, $request->checkOut])
                      ->orWhere(function($q) use ($request) {
                          $q->where('check_in', '<=', $request->checkIn)
                            ->where('check_out', '>=', $request->checkOut);
                      });
                });
            });
        }

        // Filter by guests if provided
        if ($request->filled('adults') || $request->filled('children')) {
            $totalGuests = ($request->input('adults', 0) + $request->input('children', 0));
            $query->where('max_guests', '>=', $totalGuests);
        }

        // Filter by rooms if provided
        if ($request->filled('rooms')) {
            $query->has('rooms', '>=', $request->rooms);
        }



        // Include essential relationships and optimize review queries
        $query->with(['amenities', 'photos', 'reviews'])
              ->withCount('reviews')
              ->withAvg('reviews', 'rating');

        // Get the results
        $properties = $query->paginate(10);

        return view('Customer.search-results', compact('properties'));
    }
}
