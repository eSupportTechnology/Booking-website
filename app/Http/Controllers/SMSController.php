<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTOs\SMS\SendSingleSMSDTO;
use App\Actions\SMS\SendSingleSMSAction;
use App\Services\OTPService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SMSController extends Controller
{
    protected OTPService $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function send(Request $request)
    {
        $request->validate(['phone_number' => 'required|string|min:10']);

        Log::info('Send OTP request received', [
            'phone_number' => $request->phone_number,
            'raw_input' => $request->all()
        ]);

        $success = $this->otpService->send($request->phone_number);

        Log::info('Send OTP result', [
            'phone_number' => $request->phone_number,
            'success' => $success
        ]);

        return response()->json([
            'success' => $success,
            'message' => $success ? 'OTP sent.' : 'Failed to send OTP.'
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'otp' => 'required|string'
        ]);

        Log::info('Verify OTP request received', [
            'phone_number' => $request->phone_number,
            'otp' => $request->otp,
            'raw_input' => $request->all()
        ]);

        $valid = $this->otpService->verify($request->phone_number, $request->otp);

        Log::info('Verify OTP result', [
            'phone_number' => $request->phone_number,
            'otp' => $request->otp,
            'valid' => $valid
        ]);

        return response()->json([
            'success' => $valid,
            'message' => $valid ? 'OTP verified.' : 'Invalid OTP.'
        ]);
    }
}
