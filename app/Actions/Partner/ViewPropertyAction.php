<?php

namespace App\Actions\Partner;

use App\Models\Property;

class ViewPropertyAction
{
    public function execute(int $id): array
    {
        // Load basic property first
        $property = Property::find($id);
        
        if (!$property) {
            return ['property' => null];
        }
        
        // Try to load each relationship individually with error handling
        $relationships = [
            'amenities',
            'additionalDetails', 
            'policies',
            'services',
            'languages',
            'hostProfile',
            'pricing',
            'facilities',
            'bedrooms',
            'files'
        ];
        
        foreach ($relationships as $relationship) {
            try {
                $property->load($relationship);
            } catch (\Exception $e) {
                // Relationship table doesn't exist, continue without it
            }
        }

        return [
            'property' => $property
        ];
    }
}