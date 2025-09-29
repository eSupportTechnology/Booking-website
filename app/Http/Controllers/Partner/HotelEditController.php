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
        $languages = Language::where('id', '>', 0)->get();
        $roomTypes = RoomType::all();
        $groupedAmenities = Amenity::all()->groupBy('category');
        $categoryId = 2;
        
        return view('partner.hotel-edit.partner-hotels-edit-edit', compact('property', 'rooms', 'hasPhotos', 'hasRooms', 'hasAmenities', 'hasPolicies', 'hasPaymentDetails', 'subcategories', 'amenities', 'languages', 'roomTypes', 'groupedAmenities', 'categoryId'))->with('propertyModel', $property);
    }
    
    public function edit(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        $subcategories = PropertySubcategory::where('category_id', 2)->get();
        $amenities = Amenity::all();
        $languages = Language::where('id', '>', 0)->get();
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
    
    // API methods for AJAX calls
    public function getPropertyData(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        return response()->json([
            'success' => true,
            'property' => $property
        ]);
    }
    
    public function getAmenities(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        return response()->json([
            'success' => true,
            'amenities' => $property->amenities->pluck('id')->toArray()
        ]);
    }
    
    public function getLanguages(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        return response()->json([
            'success' => true,
            'languages' => $property->languages->pluck('id')->toArray()
        ]);
    }
    
    public function getPolicies(Property $property)
    {
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }
        
        return response()->json([
            'success' => true,
            'houseRules' => [
                'smoking_allowed' => $property->smoking_allowed,
                'children_allowed' => $property->children_allowed,
                'parties_allowed' => $property->parties_allowed,
                'pets_allowed' => $property->pets_allowed,
                'pets_fees' => $property->pets_fees,
                'check_in_from' => $property->check_in_from,
                'check_in_until' => $property->check_in_until,
                'check_out_from' => $property->check_out_from,
                'check_out_until' => $property->check_out_until,
                'cancellation_policy' => $property->cancellation_policy
            ]
        ]);
    }
}