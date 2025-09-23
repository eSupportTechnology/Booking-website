<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Amenity;
use App\Models\RoomType;
use App\Actions\Partner\GetHotelEditDataAction;
use Illuminate\Http\Request;

class HotelEditController extends Controller
{
    public function edit(Property $property, GetHotelEditDataAction $action)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        $data = $action->execute($property);
        return view('partner.partner-hotels-edit', $data);
    }
    
    public function editPhotos(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('partner.partner-hotels-photos', compact('property'));
    }
    
    public function editRooms(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        $roomTypes = RoomType::all();
        $groupedAmenities = Amenity::all()->groupBy('category');
        
        return view('partner.partner-hotels-rooms', compact('property', 'roomTypes', 'groupedAmenities'));
    }
    
    public function editPayment(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('partner.partner-hotels-payment', ['propertyModel' => $property]);
    }
    
    public function completeRegistration(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('partner.partner-hotels-complete-registration', compact('property'));
    }
}