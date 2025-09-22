<?php

namespace App\Actions\Partner;

use App\Models\Property;
use App\Models\Room;
use App\Models\Amenity;
use App\Models\Language;

class GetHomeEditDataAction
{
    public function execute(Property $property): array
    {
        $property->load([
            'category',
            'amenities',
            'files',
            'bedrooms',
            'additionalDetails',
            'policies',
            'services',
            'languages',
            'hostProfile',
            'pricing',
            'facilities',
            'availabilitySettings'
        ]);
        
        // Ensure amenities are loaded with pivot data
        $property->amenities = $property->amenities()->get();
        $property->facilities = $property->facilities()->get();

        $rooms = Room::where('property_id', $property->id)
            ->with(['roomType', 'beds'])
            ->get()
            ->groupBy('room_type_id');

        $groupedAmenities = Amenity::all()->groupBy('category');
        $allLanguages = Language::all();

        return [
            'property' => $property,
            'rooms' => $rooms,
            'groupedAmenities' => $groupedAmenities,
            'allLanguages' => $allLanguages,
            'isEdit' => true
        ];
    }
}