<?php

namespace App\Actions\Partner;

use App\Services\Partner\PropertyService;

class GetBookingDataAction
{
    public function __construct(
        private PropertyService $propertyService
    ) {}

    public function execute(): array
    {
        return [
            'bookings' => $this->propertyService->getBookings(),
            'stats' => $this->propertyService->getBookingStats()
        ];
    }
}