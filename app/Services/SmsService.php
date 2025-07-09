<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class QuickSendSmsService
{
    private string $email;
    private string $apiKey;
    private string $baseUrl;
    private string $defaultSenderId;

    public function __construct()
    {
        $this->email = config('services.quicksend.email');
        $this->apiKey = config('services.quicksend.api_key');
        $this->baseUrl = config('services.quicksend.base_url', 'https://quicksend.lk/Client/api.php');
        $this->defaultSenderId = config('services.quicksend.sender_id', 'QKSendDemo');
    }

    public function sendSingleSms(string $to, string $message, ?string $senderId = null): array
    {
        $senderId = $senderId ?? $this->defaultSenderId;

        $data = [
            'senderID' => $senderId,
            'to' => $to,
            'msg' => $message
        ];

        try {
            $response = Http::withBasicAuth($this->email, $this->apiKey)
                ->post($this->baseUrl . '?FUN=SEND_SINGLE', $data);

            if ($response->successful()) {
                $result = $response->json() ?? ['status' => 'success', 'raw_response' => $response->body()];

                Log::info('SMS sent successfully', [
                    'to' => $to,
                    'sender_id' => $senderId,
                    'response' => $result
                ]);

                return $result;
            } else {
                $errorMessage = "Failed to send SMS. HTTP Status: " . $response->status();
                Log::error($errorMessage, [
                    'to' => $to,
                    'response_body' => $response->body(),
                    'status_code' => $response->status()
                ]);

                throw new Exception($errorMessage);
            }
        } catch (Exception $e) {
            Log::error('SMS sending failed with exception', [
                'to' => $to,
                'error' => $e->getMessage()
            ]);

            throw new Exception('SMS sending failed: ' . $e->getMessage());
        }
    }

    public function sendSingleSmsGet(string $to, string $message, ?string $senderId = null): array
    {
        $senderId = $senderId ?? $this->defaultSenderId;

        $params = [
            'FUN' => 'SEND_SINGLE',
            'with_get' => 'true',
            'un' => $this->email,
            'up' => $this->apiKey,
            'senderID' => $senderId,
            'msg' => $message,
            'to' => $to
        ];

        try {
            $response = Http::get($this->baseUrl, $params);

            if ($response->successful()) {
                $result = $response->json() ?? ['status' => 'success', 'raw_response' => $response->body()];

                Log::info('SMS sent successfully via GET', [
                    'to' => $to,
                    'sender_id' => $senderId,
                    'response' => $result
                ]);

                return $result;
            } else {
                $errorMessage = "Failed to send SMS via GET. HTTP Status: " . $response->status();
                Log::error($errorMessage, [
                    'to' => $to,
                    'response_body' => $response->body(),
                    'status_code' => $response->status()
                ]);

                throw new Exception($errorMessage);
            }
        } catch (Exception $e) {
            Log::error('SMS sending via GET failed with exception', [
                'to' => $to,
                'error' => $e->getMessage()
            ]);

            throw new Exception('SMS sending via GET failed: ' . $e->getMessage());
        }
    }

    public function validatePhoneNumber(string $phoneNumber): bool
    {
        // Basic validation for Sri Lankan phone numbers
        // Adjust pattern based on your requirements
        return preg_match('/^07[0-9]{8}$/', $phoneNumber) === 1;
    }

    public function formatPhoneNumber(string $phoneNumber): string
    {
        // Remove any spaces, dashes, or special characters
        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Ensure it starts with 0 for local numbers
        if (strlen($cleaned) === 9 && substr($cleaned, 0, 1) === '7') {
            $cleaned = '0' . $cleaned;
        }

        return $cleaned;
    }
}
