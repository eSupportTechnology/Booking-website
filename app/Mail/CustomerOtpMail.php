<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public int $otp) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Verification Code',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.customer.otp',
            with: [
                'otp' => $this->otp,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
