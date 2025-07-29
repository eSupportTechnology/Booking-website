<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\SaveBedroomDTO;
use App\Models\Property;
use Illuminate\Support\Facades\Log;

class SaveBedroomAction
{
    public function execute(SaveBedroomDTO $dto, Property $property): void
    {
        Log::info('SaveBedroomAction::execute called', [
            'property_id' => $property->id,
            'dto_data' => $dto->toArray()
        ]);

        $room = $property->rooms()->updateOrCreate(
            ['name' => $dto->room_name],
            ['room_type_id' => 1] // Assuming 'bedroom' type
        );

        $bedData = [];
        foreach ($dto->beds as $bed) {
            if ($bed['count'] > 0) {
                $bedData[$bed['id']] = ['count' => $bed['count']];
            }
        }

        $room->beds()->sync($bedData);

        Log::info('Bedroom saved successfully', [
            'property_id' => $property->id,
            'room_id' => $room->id,
            'bed_data' => $bedData
        ]);
    }
} 