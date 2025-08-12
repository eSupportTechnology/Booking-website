<?php

namespace App\Actions\Partner;

use App\Services\Partner\PropertyService;

class GetPropertyByTypeAction
{
    public function __construct(
        private PropertyService $propertyService
    ) {}

    public function execute(string $type): array
    {
        return [
            'properties' => $this->propertyService->getPropertiesByType($type)
        ];
    }
}