<?php

namespace App\Actions\Sms;

use App\DTOs\SendSingleSmsDTO;
use Illuminate\Support\Facades\Http;

class SendSingleSmsAction
{
    public function execute(SendSingleSmsDTO $data): array
    {
        $response = Http::withBasicAuth(
            config('services.quicksend.email'),
            config('services.quicksend.api_key')
        )->post('https://quicksend.lk/Client/api.php?FUN=SEND_SINGLE', [
            'senderID' => $data->senderID,
            'to'       => $data->to,
            'msg'      => $data->msg,
        ]);

        return $response->json();
    }
}

