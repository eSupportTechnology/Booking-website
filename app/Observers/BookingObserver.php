<?php

namespace App\Observers;

use App\Models\Booking;

class BookingObserver
{
    public function updated(Booking $booking)
    {
        // Generate commission when booking is confirmed
        if ($booking->wasChanged('status') && $booking->status === 'confirmed') {
            $booking->generateCommission();
        }
    }
}