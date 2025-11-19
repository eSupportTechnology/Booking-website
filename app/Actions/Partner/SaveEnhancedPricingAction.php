<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\EnhancedPricingDTO;
use App\Models\Property;

class SaveEnhancedPricingAction
{
    public function execute(EnhancedPricingDTO $dto, Property $property): void
    {
        $totalPrice = $dto->calculateTotalPrice();
        
        // Update property pricing
        $property->update([
            'adult_price' => $dto->adult_price,
            'child_price' => $dto->child_price,
            'commission_rate' => $dto->commission_rate,
            'total_price_with_commission' => $totalPrice,
            'price_per_night' => $totalPrice, // For backward compatibility
        ]);
        
        // Also update property_pricings table if exists
        $property->pricing()->updateOrCreate(
            ['property_id' => $property->id],
            [
                'adult_price' => $dto->adult_price,
                'child_price' => $dto->child_price,
                'commission_rate' => $dto->commission_rate,
                'total_price_with_commission' => $totalPrice,
                'price_per_night' => $totalPrice,
            ]
        );
    }
}