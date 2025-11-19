<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoManagementController extends Controller
{
    public function reorderPhotos(Request $request, $propertyId)
    {
        $property = Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $photoIds = $request->input('photo_ids', []);
        
        foreach ($photoIds as $index => $photoId) {
            PropertyPhoto::where('id', $photoId)
                ->where('property_id', $propertyId)
                ->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function updateCaption(Request $request, $propertyId, $photoId)
    {
        $property = Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $photo = PropertyPhoto::where('id', $photoId)
            ->where('property_id', $propertyId)
            ->firstOrFail();

        $request->validate([
            'caption' => 'nullable|string|max:255'
        ]);

        $photo->update(['caption' => $request->input('caption')]);

        return response()->json(['success' => true]);
    }

    public function deletePhoto(Request $request, $propertyId, $photoId)
    {
        $property = Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $photo = PropertyPhoto::where('id', $photoId)
            ->where('property_id', $propertyId)
            ->firstOrFail();

        // Delete file from storage
        if ($photo->path && Storage::exists($photo->path)) {
            Storage::delete($photo->path);
        }

        $photo->delete();

        return response()->json(['success' => true]);
    }

    public function setPrimary(Request $request, $propertyId, $photoId)
    {
        $property = Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Remove primary flag from all photos
        PropertyPhoto::where('property_id', $propertyId)
            ->update(['is_primary' => false]);

        // Set new primary photo
        PropertyPhoto::where('id', $photoId)
            ->where('property_id', $propertyId)
            ->update(['is_primary' => true]);

        return response()->json(['success' => true]);
    }

    public function uploadPhotos(Request $request, $propertyId)
    {
        $property = Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $uploadedPhotos = [];
        
        foreach ($request->file('photos', []) as $photo) {
            $path = $photo->store('property_photos', 'public');
            
            $propertyPhoto = PropertyPhoto::create([
                'property_id' => $propertyId,
                'path' => $path,
                'filename' => $photo->getClientOriginalName(),
                'sort_order' => PropertyPhoto::where('property_id', $propertyId)->count() + 1,
                'is_primary' => PropertyPhoto::where('property_id', $propertyId)->count() === 0,
            ]);

            $uploadedPhotos[] = [
                'id' => $propertyPhoto->id,
                'url' => Storage::url($path),
                'caption' => $propertyPhoto->caption,
                'is_primary' => $propertyPhoto->is_primary,
            ];
        }

        return response()->json([
            'success' => true,
            'photos' => $uploadedPhotos
        ]);
    }
}