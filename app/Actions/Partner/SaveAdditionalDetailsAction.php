<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\SaveAdditionalDetailsDTO;
use App\Models\Property;
use Illuminate\Support\Facades\Log;

class SaveAdditionalDetailsAction
{
    public function execute(SaveAdditionalDetailsDTO $dto): void
    {
        Log::info('SaveAdditionalDetailsAction::execute called', [
            'property_id' => $dto->property_id,
            'dto_data' => $dto->toArray()
        ]);

        $property = Property::findOrFail($dto->property_id);

        // Save languages if provided
        if (!empty($dto->languages)) {
            $property->languages()->sync($dto->languages);
        }

        Log::info('Additional details saved successfully', [
            'property_id' => $dto->property_id,
            'languages' => $dto->languages
        ]);
    }
} 