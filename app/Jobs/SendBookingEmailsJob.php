<?php

namespace App\Jobs;

use App\Mail\BookingConfirmationGuest;
use App\Mail\BookingNotificationPartner;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBookingEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Booking $booking
    ) {}

    public function handle(): void
    {
        // Send confirmation email to guest
        Mail::to($this->booking->user->email)
            ->send(new BookingConfirmationGuest($this->booking));

        // Send notification email to partner
        Mail::to($this->booking->property->user->email)
            ->send(new BookingNotificationPartner($this->booking));
    }
}