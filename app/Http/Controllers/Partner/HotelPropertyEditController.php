<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Amenity;
use App\Models\RoomType;
use App\Actions\Partner\GetHotelEditDataAction;
use App\Actions\Partner\UpdateHotelPropertyAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HotelPropertyEditController extends Controller
{
    public function edit(Property $property, GetHotelEditDataAction $action)
    {
        // Verify ownership
        if ($property->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to property');
        }
        
        $data = $action->execute($property);
        $data['amenities'] = Amenity::all()->groupBy('category');
        $data['roomTypes'] = RoomType::all();
        
        return view('partner.hotel-edit.partner-hotels-edit-edit', $data);
    }
    
    public function update(Property $property, Request $request, UpdateHotelPropertyAction $action)
    {
        // Verify ownership
        if ($property->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $validated = $this->validateRequest($request);
        $result = $action->execute($property, $validated);
        
        if ($request->expectsJson()) {
            return response()->json($result);
        }
        
        if ($result['success']) {
            return redirect()->route('partner.hotels.edit.new', $property)
                ->with('success', $result['message']);
        }
        
        return back()->withErrors(['error' => $result['message']]);
    }
    
    public function updateBasicDetails(Property $property, Request $request): JsonResponse
    {
        if ($property->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'zipcode' => 'nullable|string|max:20',
            'stars' => 'nullable|integer|min:1|max:5',
        ]);
        
        $property->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Basic details updated successfully'
        ]);
    }
    
    public function updateAmenities(Property $property, Request $request): JsonResponse
    {
        if ($property->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'amenities' => 'array',
            'amenities.*' => 'exists:amenities,id'
        ]);
        
        $property->amenities()->sync($validated['amenities'] ?? []);
        
        return response()->json([
            'success' => true,
            'message' => 'Amenities updated successfully'
        ]);
    }
    
    public function updatePricing(Property $property, Request $request): JsonResponse
    {
        if ($property->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'base_price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'cleaning_fee' => 'nullable|numeric|min:0',
            'service_fee' => 'nullable|numeric|min:0',
        ]);
        
        $property->pricing()->updateOrCreate(
            ['property_id' => $property->id],
            $validated
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Pricing updated successfully'
        ]);
    }
    
    public function updatePolicies(Property $property, Request $request): JsonResponse
    {
        if ($property->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'check_in_time' => 'required|string',
            'check_out_time' => 'required|string',
            'cancellation_policy' => 'required|string',
            'house_rules' => 'nullable|string|max:1000',
            'smoking_allowed' => 'boolean',
            'pets_allowed' => 'boolean',
            'parties_allowed' => 'boolean',
        ]);
        
        $property->policies()->updateOrCreate(
            ['property_id' => $property->id],
            $validated
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Policies updated successfully'
        ]);
    }
    
    public function uploadPhotos(Property $property, Request $request): JsonResponse
    {
        if ($property->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $request->validate([
            'photos' => 'required|array|max:10',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120'
        ]);
        
        $uploadedPhotos = [];
        
        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('property-photos', 'public');
            
            $propertyPhoto = $property->photos()->create([
                'photo_path' => $path,
                'is_primary' => $property->photos()->count() === 0
            ]);
            
            $uploadedPhotos[] = $propertyPhoto;
        }
        
        return response()->json([
            'success' => true,
            'message' => count($uploadedPhotos) . ' photos uploaded successfully',
            'photos' => $uploadedPhotos
        ]);
    }
    
    public function deletePhoto(Property $property, $photoId): JsonResponse
    {
        if ($property->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $photo = $property->photos()->find($photoId);
        
        if (!$photo) {
            return response()->json(['success' => false, 'message' => 'Photo not found'], 404);
        }
        
        // Delete file from storage
        if ($photo->photo_path) {
            \Storage::disk('public')->delete($photo->photo_path);
        }
        
        $photo->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Photo deleted successfully'
        ]);
    }
    
    public function setPrimaryPhoto(Property $property, $photoId): JsonResponse
    {
        if ($property->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $photo = $property->photos()->find($photoId);
        
        if (!$photo) {
            return response()->json(['success' => false, 'message' => 'Photo not found'], 404);
        }
        
        // Remove primary status from all photos
        $property->photos()->update(['is_primary' => false]);
        
        // Set this photo as primary
        $photo->update(['is_primary' => true]);
        
        return response()->json([
            'success' => true,
            'message' => 'Primary photo updated successfully'
        ]);
    }
    
    public function createRoom(Property $property, Request $request): JsonResponse
    {
        if ($property->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'max_guests' => 'required|integer|min:1',
            'bed_count' => 'required|integer|min:1',
            'bathroom_type' => 'required|in:private,shared',
            'price_per_night' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
        ]);
        
        $validated['room_type_id'] = 1; // Default room type
        $room = $property->rooms()->create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Room created successfully',
            'room' => $room
        ]);
    }
    
    public function updateRoom(Property $property, $roomId, Request $request): JsonResponse
    {
        if ($property->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $room = $property->rooms()->find($roomId);
        
        if (!$room) {
            return response()->json(['success' => false, 'message' => 'Room not found'], 404);
        }
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'max_guests' => 'sometimes|required|integer|min:1',
            'bed_count' => 'sometimes|required|integer|min:1',
            'bathroom_type' => 'sometimes|required|in:private,shared',
            'price_per_night' => 'sometimes|required|numeric|min:0',
            'currency' => 'sometimes|required|string|size:3',
        ]);
        
        $room->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Room updated successfully',
            'room' => $room->fresh()
        ]);
    }
    
    public function deleteRoomType(Property $property, $roomTypeId): JsonResponse
    {
        if ($property->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $deletedCount = $property->rooms()->where('id', $roomTypeId)->delete();
        
        return response()->json([
            'success' => true,
            'message' => "Deleted {$deletedCount} room(s) successfully"
        ]);
    }
    
    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:2000',
            'address' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:100',
            'country' => 'sometimes|required|string|max:100',
            'zipcode' => 'nullable|string|max:20',
            'stars' => 'nullable|integer|min:1|max:5',
            'amenities' => 'sometimes|array',
            'amenities.*' => 'exists:amenities,id',
            'facilities' => 'sometimes|array',
            'facilities.*.name' => 'required|string|max:255',
            'facilities.*.description' => 'nullable|string|max:500',
            'facilities.*.is_available' => 'boolean',
            'services' => 'sometimes|array',
            'pricing' => 'sometimes|array',
            'pricing.base_price' => 'required|numeric|min:0',
            'pricing.currency' => 'required|string|size:3',
            'policies' => 'sometimes|array',
            'host_profile' => 'sometimes|array',
            'photos' => 'sometimes|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            'rooms' => 'sometimes|array',
        ]);
    }
}