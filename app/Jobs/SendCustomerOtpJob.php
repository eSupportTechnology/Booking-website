<?php

namespace App\Jobs;

use App\Mail\CustomerOtpMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCustomerOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 120;

    public function __construct(
        public string $email,
        public int $otp
    ) {}

    public function handle(): void
    {
        try {
            Log::info("Sending OTP email to: {$this->email}");

            Mail::to($this->email)->send(new CustomerOtpMail($this->otp));

            Log::info("OTP email sent successfully to: {$this->email}");
        } catch (\Throwable $e) {
            Log::error("Failed to send OTP email to {$this->email}: " . $e->getMessage());
            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("OTP email job failed for {$this->email}: " . $exception->getMessage());
    }
}
