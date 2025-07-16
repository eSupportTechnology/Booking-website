<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailOtpMailable extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $otp) {}

    public function build()
    {
         return $this
        ->subject('Your Verification Code')
        ->markdown('emails.customer.email-verify') 
        ->with(['otp' => $this->otp]);
    }
}
