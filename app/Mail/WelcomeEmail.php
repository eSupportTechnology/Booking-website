<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $userName
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Our Platform!',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.customer.welcome',
            with: [
                'userName' => $this->userName,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
