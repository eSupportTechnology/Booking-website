<?php

namespace App\Observers;

use App\Jobs\SendBookingEmailsJob;
use App\Models\Booking;

class BookingObserver
{
    public function created(Booking $booking)
    {
        // Send booking emails when booking is created
        SendBookingEmailsJob::dispatch($booking);
    }

    public function updated(Booking $booking)
    {
        // Generate commission when booking is confirmed
        if ($booking->wasChanged('status') && $booking->status === 'confirmed') {
            $booking->generateCommission();
        }
    }
}