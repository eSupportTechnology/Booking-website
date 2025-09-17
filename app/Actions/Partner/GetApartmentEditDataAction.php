<?php

namespace App\Actions\Partner;

use App\Models\Property;
use App\Models\Amenity;

class GetApartmentEditDataAction
{
    public function execute(Property $property): array
    {
        $property->load([
            'amenities',
            'photos',
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

        $groupedAmenities = Amenity::all()->groupBy('category');

        return [
            'property' => $property,
            'groupedAmenities' => $groupedAmenities,
            'category' => 'apartment',
            'isEdit' => true
        ];
    }
}