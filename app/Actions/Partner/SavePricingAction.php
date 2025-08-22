<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\SavePricingDTO;
use App\Models\Property;
use Illuminate\Support\Facades\Log;

class SavePricingAction
{
    public function execute(SavePricingDTO $dto, Property $property): void
    {
        Log::info('SavePricingAction::execute called', [
            'property_id' => $property->id,
            'dto_data' => $dto->toArray()
        ]);

        Log::info('Before updateOrCreate', [
            'property_id' => $property->id
        ]);

        $property->pricing()->updateOrCreate(
            ['property_id' => $property->id],
            $dto->toArray()
        );

        Log::info('After updateOrCreate', [
            'property_id' => $property->id
        ]);

        Log::info('Pricing saved successfully', [
            'property_id' => $property->id, 
            'data' => $dto->toArray()
        ]);
    }
} 