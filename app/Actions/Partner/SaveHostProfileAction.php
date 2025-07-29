<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\SaveHostProfileDTO;
use App\Models\Property;
use Illuminate\Support\Facades\Log;

class SaveHostProfileAction
{
    public function execute(SaveHostProfileDTO $dto, Property $property): void
    {
        Log::info('SaveHostProfileAction::execute called', [
            'property_id' => $property->id,
            'dto_data' => $dto->toArray()
        ]);

        // Update the property title with the host name
        if (!empty($dto->host_name)) {
            $property->update(['title' => $dto->host_name]);
            Log::info('Property title updated', [
                'property_id' => $property->id, 
                'title' => $dto->host_name
            ]);
        }

        $property->hostProfile()->updateOrCreate(
            ['property_id' => $property->id],
            $dto->toArray()
        );

        Log::info('Host profile saved successfully', [
            'property_id' => $property->id, 
            'data' => $dto->toArray()
        ]);
    }
} 