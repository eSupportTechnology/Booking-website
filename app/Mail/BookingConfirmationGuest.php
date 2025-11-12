<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationGuest extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Confirmation - ' . $this->booking->property->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bookings.guest-confirmation',
            with: [
                'booking' => $this->booking,
                'property' => $this->booking->property,
                'guest' => $this->booking->user,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}