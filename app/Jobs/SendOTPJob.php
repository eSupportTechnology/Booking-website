<?php

namespace App\Jobs;

use App\DTOs\SMS\SendSingleSMSDTO;
use App\Actions\SMS\SendSingleSMSAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendOTPJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected SendSingleSMSDTO $dto;

    public function __construct(SendSingleSMSDTO $dto)
    {
        $this->dto = $dto;
    }

    public function handle(SendSingleSMSAction $action): void
{
    try {
        $response = $action->execute($this->dto);
        Log::info('OTP Job executed successfully', ['response' => $response]);
    } catch (\Exception $e) {
        Log::error('OTP Job execution failed', ['error' => $e->getMessage()]);
        throw $e; // Re-throw to trigger job retry mechanism
    }
}
}
