<?php

namespace App\Actions\Customer;

use App\DTOs\Customer\BookingDTO;
use App\Services\Customer\BookingService;
use App\Models\Booking;

class CreateBookingAction
{
    public function __construct(
        private BookingService $bookingService
    ) {}

    public function execute(BookingDTO $bookingDTO): Booking
    {
        return $this->bookingService->createBooking($bookingDTO);
    }
}