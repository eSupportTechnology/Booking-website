<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Amenity;
use App\Models\RoomType;
use App\Models\PropertySubcategory;
use App\Models\Language;
use App\Models\Room;
use Illuminate\Http\Request;

class HotelEditController extends Controller
{
    public function overview(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Get rooms grouped by room type
        $rooms = Room::where('property_id', $property->id)
            ->with('roomType')
            ->get()
            ->groupBy('room_type_id');
            
        // Check completion status
        $hasPhotos = $property->photos()->exists();
        $hasRooms = $rooms->isNotEmpty();
        $hasAmenities = $property->amenities()->exists();
        $hasPolicies = !empty($property->cancellation_policy);
        $hasPaymentDetails = !empty($property->payment_method) && !empty($property->invoice_name);
        
        // Get required data for the partials
        $subcategories = PropertySubcategory::where('category_id', 2)->get();
        $amenities = Amenity::all();
        $languages = Language::all();
        $categoryId = 2;
        
        return view('partner.hotel-edit.partner-hotels-edit', compact('property', 'rooms', 'hasPhotos', 'hasRooms', 'hasAmenities', 'hasPolicies', 'hasPaymentDetails', 'subcategories', 'amenities', 'languages', 'categoryId'));
    }
    
    public function edit(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        $subcategories = PropertySubcategory::where('category_id', 2)->get();
        $amenities = Amenity::all();
        $languages = Language::all();
        $categoryId = 2;
        
        return view('partner.partner-hotels-create-1', compact('property', 'subcategories', 'amenities', 'languages', 'categoryId'));
    }
    
    public function editAmenities(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('partner.partner-hotels-create-2', compact('property'));
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
    
    public function editPolicies(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('partner.partner-hotels-complete-registration', compact('property'));
    }
}