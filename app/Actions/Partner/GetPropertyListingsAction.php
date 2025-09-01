<?php

namespace App\Actions\Partner;

use App\Services\Partner\PropertyListingService;

class GetPropertyListingsAction
{
    public function __construct(
        private PropertyListingService $propertyListingService
    ) {}

    public function execute(string $type, ?string $search = null, ?string $status = null): array
    {
        $method = 'get' . ucfirst($type);
        
        return [
            'properties' => $this->propertyListingService->$method($search, $status),
            'counts' => $this->propertyListingService->getPropertyCounts(),
            'type' => $type,
            'search' => $search,
            'status' => $status
        ];
    }
}