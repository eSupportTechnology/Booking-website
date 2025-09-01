<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admin Reset Password Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_reset_password',
        );
    }

    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        $resetUrl = url(route('admin.password.reset', [
            'token' => $this->token,
            'email' => $this->email,
        ], false));

        return $this->subject('Reset Your Admin Password')
            ->markdown('emails.admin_reset_password')
            ->with([
                'resetUrl' => $resetUrl,
            ]);
    }
}