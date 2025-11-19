<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Amenity;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyEditController extends Controller
{
    public function edit($id)
    {
        $property = Property::with(['amenities', 'additionalDetails', 'files'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
            
        return view('property.edit.index', compact('property'));
    }

    public function updateBasic(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string'
        ]);

        Property::where('id', $id)->where('user_id', Auth::id())->update([
            'title' => $request->title,
            'description' => $request->description,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country
        ]);

        session()->flash('success', 'Basic details updated successfully!');
        return response()->json(['success' => true, 'message' => 'Basic details updated successfully!']);
    }

    public function updateDetails(Request $request, $id)
    {
        $request->validate([
            'guests' => 'required|integer|min:1',
            'bedrooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'amenities' => 'array'
        ]);

        $property = Property::where('user_id', Auth::id())->findOrFail($id);
        
        $property->additionalDetails()->updateOrCreate([], [
            'guests_capacity' => $request->guests,
            'bedrooms_count' => $request->bedrooms,
            'bathrooms_count' => $request->bathrooms
        ]);

        if ($request->amenities) {
            $property->amenities()->sync($request->amenities);
        }

        session()->flash('success', 'Property details updated successfully!');
        return response()->json(['success' => true, 'message' => 'Property details updated successfully!']);
    }

    public function updatePricing(Request $request, $id)
    {
        $request->validate([
            'adult_price' => 'required|numeric|min:0',
            'children_price' => 'required|numeric|min:0'
        ]);

        Property::where('id', $id)->where('user_id', Auth::id())->update([
            'adult_price' => $request->adult_price,
            'children_price' => $request->children_price
            // Commission rate is not updated - it's set by admin
        ]);

        session()->flash('success', 'Pricing updated successfully!');
        return response()->json(['success' => true, 'message' => 'Pricing updated successfully!']);
    }

    public function uploadPhotos(Request $request, $id)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $property = Property::where('user_id', Auth::id())->findOrFail($id);
        
        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('properties', 'public');
            $property->files()->create([
                'path' => $path,
                'file_type' => 'image'
            ]);
        }

        session()->flash('success', 'Photos uploaded successfully!');
        return response()->json(['success' => true, 'message' => 'Photos uploaded successfully!']);
    }
}