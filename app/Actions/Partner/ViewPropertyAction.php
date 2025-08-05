<?php

namespace App\Actions\Partner;

use App\Models\Property;

class ViewPropertyAction
{
    public function execute(int $id): array
    {
        $property = Property::with([
            'amenities',
            'additionalDetails',
            'policies',
            'services',
            'languages',
            'hostProfile',
            'pricing',
            'facilities',
            'bedrooms'
        ])->find($id);
        
        // Try to load photos if table exists
        try {
            $property->load('photos');
        } catch (\Exception $e) {
            // Photos table doesn't exist, continue without photos
        }

        return [
            'property' => $property
        ];
    }
}