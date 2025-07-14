<?php

namespace App\Jobs;

use App\Mail\SendEmailOtpMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 60;

    public function __construct(
        private string $email,
        private string $otp
    ) {}

    public function handle(): void
    {
        try {
            Mail::to($this->email)
                ->send(new SendEmailOtpMailable($this->otp));

            Log::info('Email OTP sent successfully', [
                'email' => $this->email,
                'job_id' => $this->job?->getJobId() ?? null,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send email OTP', [
                'email' => $this->email,
                'error' => $e->getMessage(),
                'job_id' => $this->job?->getJobId() ?? null,
            ]);
            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Email OTP job failed permanently', [
            'email' => $this->email,
            'error' => $exception->getMessage(),
            'job_id' => $this->job?->getJobId() ?? null,
        ]);
    }
}
