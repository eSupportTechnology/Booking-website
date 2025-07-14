<?php

namespace App\Actions\SMS;

use App\DTOs\SMS\SendSingleSMSDTO;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendSingleSMSAction
{
    public function execute(SendSingleSMSDTO $dto): array
    {

        $url = config('services.quicksend.base_url');
        try {
            $response = Http::withBasicAuth(
                config('services.quicksend.email'),
                config('services.quicksend.api_key')
            )->post($url, [
                'FUN' => 'SEND_SINGLE',
                'senderID' => config('services.quicksend.sender_id'),
                'to' => $dto->to,
                'msg' => $dto->message,
            ]);

            // Log everything
            Log::info('QuickSend API Raw Response', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('QuickSend API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return [
                    'success' => false,
                    'error' => 'API request failed',
                    'status' => $response->status(),
                ];
            }
        } catch (\Exception $e) {
            Log::error('QuickSend API Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'error' => 'API request exception',
                'message' => $e->getMessage(),
            ];
        }
    }
}
