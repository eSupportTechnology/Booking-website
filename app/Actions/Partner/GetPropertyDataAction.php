<?php

namespace App\Actions\Partner;

use App\Services\Partner\PropertyService;

class GetPropertyDataAction
{
    public function __construct(
        private PropertyService $propertyService
    ) {}

    public function execute(): array
    {
        return [
            'stats' => $this->propertyService->getPropertyStats(),
            'properties' => $this->propertyService->getProperties()
        ];
    }
}