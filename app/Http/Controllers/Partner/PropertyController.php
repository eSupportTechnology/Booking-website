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

    public function apartments(GetPropertyByTypeAction $action)
    {
        $data = $action->execute('apartments');

        return view('partner.properties.apartments', $data);
    }

    public function homes(GetPropertyByTypeAction $action)
    {
        $data = $action->execute('homes');

        return view('partner.properties.homes', $data);
    }

    public function hotels(GetPropertyByTypeAction $action)
    {
        $data = $action->execute('hotels');

        return view('partner.properties.hotels', $data);
    }

    public function alternativePlaces(GetPropertyByTypeAction $action)
    {
        $data = $action->execute('alternative-places');

        return view('partner.properties.alternative-places', $data);
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

        $categoryName = strtolower($property->category->name ?? 'home');

        // Redirect to specific property type edit controllers
        switch ($categoryName) {
            case 'homes':
                return redirect()->route('partner.homes.edit', $property->id);
            case 'apartment':
                return redirect()->route('partner.apartments.edit', $property->id);
            case 'hotel, b&bs, and more':
                return redirect()->route('partner.hotels.edit.new', $property->id);
            default:
                return redirect()->route('partner.homes.edit', $property->id);
        }
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

    // Get trending cities based on property listings customer home page
public function getTrendingCities()
{
    $topCities = DB::table('properties')
        ->select('city', DB::raw('COUNT(*) as total'))
        ->groupBy('city')
        ->orderByDesc('total')
        ->take(5) // or any number you want
        ->get();

    $citiesWithImages = $topCities->map(function ($city) {
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
            'count' => $city->total,
            'image' => $imageUrl,
        ];
    });

    return response()->json($citiesWithImages);
}

}
