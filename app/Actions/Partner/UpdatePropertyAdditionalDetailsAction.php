<?php

namespace App\Actions\Partner;

use App\Models\Property;
use App\DTOs\Partner\PropertyAdditionalDetailsDTO;

class UpdatePropertyAdditionalDetailsAction
{
    public function execute(Property $property, PropertyAdditionalDetailsDTO $dto)
    {
        return $property->additionalDetails()->updateOrCreate([], [
            'guests' => $dto->guests,
            'bathrooms' => $dto->bathrooms,
            'allow_children' => $dto->allow_children,
            'offer_cribs' => $dto->offer_cribs,
            'apartment_size' => $dto->apartment_size,
            'apartment_unit' => $dto->apartment_unit,
        ]);
    }
}
