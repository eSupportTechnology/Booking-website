<?php

namespace App\Actions\SMS;

use App\DTOs\SMS\SendSingleSMSDTO;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendSingleSMSAction
{
    public function execute(SendSingleSMSDTO $dto): array
{
    $url = config('services.quicksend.base_url') . '?FUN=SEND_SINGLE';

    $response = Http::withBasicAuth(
        config('services.quicksend.email'),
        config('services.quicksend.api_key')
    )->post($url, [
        'senderID' => config('services.quicksend.sender_id'),
        'to'       => $dto->to,
        'msg'      => $dto->message,
    ]);

    // Log everything
    Log::info('QuickSend API Raw Response', [
        'status' => $response->status(),
        'body'   => $response->body(),
    ]);

    return $response->json();
}
}
