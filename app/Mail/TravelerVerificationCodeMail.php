<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TravelerVerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $code;
    public $email;

    public function __construct($email, $code)
    {
        $this->email = $email;
        $this->code = $code;
        $this->name = explode('@', $email)[0]; // Simplified name
    }

    public function build()
    {
        return $this->subject('Verify your email address')
                    ->markdown('emails.traveler.code');
    }
}
