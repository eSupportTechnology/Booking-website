<?php

namespace App\Jobs;

use App\Mail\WelcomeEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 120;

    public function __construct(
        public string $email,
        public string $name
    ) {}

    public function handle(): void
    {
        try {
            Log::info("Sending welcome email to: {$this->email}");

            Mail::to($this->email)->send(new WelcomeEmail($this->name));

            Log::info("Welcome email sent successfully to: {$this->email}");
        } catch (\Throwable $e) {
            Log::error("Failed to send welcome email to {$this->email}: " . $e->getMessage());
            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("Welcome email job failed for {$this->email}: " . $exception->getMessage());
    }
}
