<?php

namespace App\Actions\Partner;

use App\Models\Property;

class UpdateHotelDataAction
{
    public function execute(Property $property, array $data): Property
    {
        $property->update([
            'title' => $data['title'] ?? $property->title,
            'description' => $data['description'] ?? $property->description,
            'address' => $data['address'] ?? $property->address,
            'city' => $data['city'] ?? $property->city,
            'country' => $data['country'] ?? $property->country,
            'zipcode' => $data['zipcode'] ?? $property->zipcode,
        ]);

        if (isset($data['amenities'])) {
            $property->amenities()->sync($data['amenities']);
        }

        return $property->fresh();
    }
}