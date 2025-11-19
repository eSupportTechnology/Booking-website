<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Actions\Partner\GetPropertyDataAction;
use App\Actions\Partner\GetBookingDataAction;
use App\Actions\Partner\GetPropertyByTypeAction;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    public function index(GetPropertyDataAction $action)
    {
        $data = $action->execute();

        return view('partner.properties.index', $data);
    }

    public function apartments()
    {
        return $this->getPropertiesByType('Apartment', 'partner.properties.apartments');
    }

    public function homes()
    {
        return $this->getPropertiesByType('Homes', 'partner.properties.homes');
    }

    public function hotels()
    {
        return $this->getPropertiesByType('Hotel, B&Bs, and more', 'partner.properties.hotels');
    }

    public function alternativePlaces()
    {
        return $this->getPropertiesByType('Alternative places', 'partner.properties.alternative-places');
    }

    private function getPropertiesByType($categoryName, $viewName)
    {
        $properties = Property::where('user_id', Auth::id())
            ->whereHas('category', function($query) use ($categoryName) {
                $query->where('name', $categoryName);
            })
            ->with(['category', 'additionalDetails', 'files'])
            ->get()
            ->map(function ($property) {
                return [
                    'id' => $property->id,
                    'name' => $property->title,
                    'location' => $property->city . ', ' . $property->country,
                    'status' => ucfirst($property->status ?? 'draft'),
                    'bookings' => $property->bookings()->count(),
                    'adult_price' => $property->adult_price ?? 0,
                    'children_price' => $property->children_price ?? 0,
                    'commission_rate' => $property->commission_rate ?? 15
                ];
            });

        $stats = (object) [
            'totalProperties' => $properties->count(),
            'activeProperties' => $properties->where('status', 'Active')->count(),
            'pendingApproval' => $properties->where('status', 'Draft')->count(),
            'inactiveProperties' => $properties->where('status', 'Inactive')->count()
        ];

        return view($viewName, compact('properties', 'stats'));
    }

    public function bookings(GetBookingDataAction $action)
    {
        $data = $action->execute();

        return view('partner.properties.bookings', $data);
    }

    public function edit($propertyId)
    {
        $property = \App\Models\Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Redirect to new unified property edit system
        return redirect()->route('property.edit', $property->id);
    }

    public function destroy($propertyId)
    {
        \Log::info('Property deletion attempt', [
            'property_id' => $propertyId,
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Unknown'
        ]);
        
        try {
            $property = \App\Models\Property::where('id', $propertyId)
                ->where('user_id', auth()->id())
                ->first();

            \Log::info('Property lookup result', [
                'property_found' => $property ? true : false,
                'property_id' => $propertyId,
                'user_id' => auth()->id()
            ]);

            if (!$property) {
                \Log::warning('Property not found or access denied', [
                    'property_id' => $propertyId,
                    'user_id' => auth()->id()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Property not found or you do not have permission to delete it'
                ], 404);
            }

            // Check if property has any active bookings
            $activeBookings = $property->bookings()->where('status', 'active')->count();
            if ($activeBookings > 0) {
                \Log::warning('Cannot delete property with active bookings', [
                    'property_id' => $propertyId,
                    'active_bookings' => $activeBookings
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete property with active bookings'
                ], 400);
            }

            // Use soft delete which is safer
            $property->delete();
            
            \Log::info('Property deleted successfully', [
                'property_id' => $propertyId,
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Property deleted successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting property: ' . $e->getMessage(), [
                'property_id' => $propertyId,
                'user_id' => auth()->id(),
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the property: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get trending cities based on property listings customer home  page
    public function getTopBookingCities()
    {
        
        $topCities = \DB::table('bookings')
            ->join('properties', 'bookings.property_id', '=', 'properties.id')
            ->select('properties.city', \DB::raw('COUNT(bookings.id) as total_bookings'))
            ->groupBy('properties.city')
            ->orderByDesc('total_bookings')
            ->take(5)
            ->get();

        
        $cities = $topCities->map(function ($city) {
            
            $filename = strtolower(str_replace(' ', '', $city->city));
            $imagePathJpg = public_path("images/{$filename}.jpg");
            $imagePathPng = public_path("images/{$filename}.png");

            
            if (file_exists($imagePathJpg)) {
                $imageUrl = asset("images/{$filename}.jpg");
            } elseif (file_exists($imagePathPng)) {
                $imageUrl = asset("images/{$filename}.png");
            } else {
                $imageUrl = asset("images/default.jpg");
            }

            return [
                'city' => $city->city,
                'image' => $imageUrl,
                'bookings' => $city->total_bookings,
            ];
        });

        
        return $cities;
    }

    public function showCities(GetPropertyDataAction $action)
    {
        
        $data = $action->execute();
        $cities = $this->getTopBookingCities();

        return view('Customer.home', array_merge($data, [
            'cities' => $cities
        ]));
    }

}
