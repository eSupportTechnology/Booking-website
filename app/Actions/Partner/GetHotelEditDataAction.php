<?php

namespace App\Actions\Partner;

use App\Models\Property;
use App\Models\Room;

class GetHotelEditDataAction
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
            'hasPhotos' => $property->photos->count() > 0,
            'hasRooms' => $rooms->count() > 0,
            'hasPaymentDetails' => $property->pricing !== null,
            'isEdit' => true
        ];
    }
}