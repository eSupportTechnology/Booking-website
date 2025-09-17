<?php

namespace App\Actions\Partner;

use App\Models\Property;
use App\Models\Room;

class GetHomeEditDataAction
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

        $rooms = Room::where('property_id', $property->id)
            ->with('roomType')
            ->get()
            ->groupBy('room_type_id');

        return [
            'property' => $property,
            'rooms' => $rooms,
            'isEdit' => true
        ];
    }
}