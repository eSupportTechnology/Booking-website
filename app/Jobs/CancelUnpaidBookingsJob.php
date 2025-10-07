<?php

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelUnpaidBookingsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $expiredBookings = Booking::where('status', 'pending')
            ->where('payment_status', 'pending')
            ->where('payment_deadline', '<', now())
            ->get();

        foreach ($expiredBookings as $booking) {
            $booking->update([
                'status' => 'cancelled',
                'payment_status' => 'expired'
            ]);
        }
    }
}