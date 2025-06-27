<?php

namespace App\Http\Controllers;

use App\DTOs\SMS\SendSmsRequestDto;
use App\DTOs\SMS\SmsResponseDto;
use App\Services\QuickSendSmsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;
use InvalidArgumentException;

class SMSController extends Controller
{
    public function __construct(
        private readonly QuickSendSmsService $smsService
    ) {}

    public function sendSms(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'phone_number' => 'required|string|min:10|max:12',
            'message' => 'required|string|max:160',
            'sender_id' => 'nullable|string|max:11'
        ]);

        try {
            $smsRequest = SendSmsRequestDto::fromArray($validatedData);
            $response = $this->smsService->sendSingleSms($smsRequest);

            return $this->formatJsonResponse($response);

        } catch (InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function sendSmsViaGet(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'phone_number' => 'required|string|min:10|max:12',
            'message' => 'required|string|max:160',
            'sender_id' => 'nullable|string|max:11'
        ]);

        try {
            $smsRequest = SendSmsRequestDto::fromArray($validatedData);
            $response = $this->smsService->sendSingleSmsViaGet($smsRequest);

            return $this->formatJsonResponse($response);

        } catch (InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    private function formatJsonResponse(SmsResponseDto $response): JsonResponse
    {
        $statusCode = $response->success ? 200 : 500;
        return response()->json($response->toArray(), $statusCode);
    }
}
