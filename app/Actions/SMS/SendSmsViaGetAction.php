<?php

namespace App\Actions\SMS;

use App\DTOs\SMS\SendSmsRequestDto;
use App\DTOs\SMS\SmsApiRequestDto;
use App\DTOs\SMS\SmsResponseDto;
use App\DTOs\SMS\QuickSendConfigDto;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class SendSmsViaGetAction
{
    public function __construct(
        private readonly ValidatePhoneNumberAction $validatePhoneAction
    ) {}

    public function execute(SendSmsRequestDto $request): SmsResponseDto
    {
        try {
            $config = QuickSendConfigDto::fromConfig();
            $validatedPhone = $this->validatePhoneAction->execute($request->phoneNumber);

            $apiRequest = new SmsApiRequestDto(
                senderID: $request->senderId ?? $config->defaultSenderId,
                to: $validatedPhone,
                msg: $request->message
            );

            $parameters = array_merge(
                $apiRequest->toGetParameters(),
                $config->getGetAuthParameters()
            );

            $response = Http::get($config->baseUrl, $parameters);

            return $this->handleApiResponse($response, $apiRequest);

        } catch (Exception $e) {
            $this->logError('SMS GET sending failed', $request, $e);
            return SmsResponseDto::failure('SMS sending via GET failed: ' . $e->getMessage());
        }
    }

    private function handleApiResponse($response, SmsApiRequestDto $apiRequest): SmsResponseDto
    {
        if ($response->successful()) {
            $responseData = $response->json() ?? ['raw_response' => $response->body()];

            $this->logSuccess('SMS sent successfully via GET', $apiRequest, $responseData);

            return SmsResponseDto::success($responseData, 'SMS sent successfully via GET');
        }

        $errorMessage = "Failed to send SMS via GET. HTTP Status: " . $response->status();
        $this->logApiError($errorMessage, $apiRequest, $response);

        return SmsResponseDto::failure(
            $errorMessage,
            (string) $response->status(),
            ['response_body' => $response->body()]
        );
    }

    private function logSuccess(string $message, SmsApiRequestDto $apiRequest, array $responseData): void
    {
        Log::info($message, [
            'to' => $apiRequest->to,
            'sender_id' => $apiRequest->senderID,
            'response' => $responseData
        ]);
    }

    private function logApiError(string $message, SmsApiRequestDto $apiRequest, $response): void
    {
        Log::error($message, [
            'to' => $apiRequest->to,
            'sender_id' => $apiRequest->senderID,
            'response_body' => $response->body(),
            'status_code' => $response->status()
        ]);
    }

    private function logError(string $message, SendSmsRequestDto $request, Exception $e): void
    {
        Log::error($message, [
            'phone_number' => $request->phoneNumber,
            'sender_id' => $request->senderId,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
}
