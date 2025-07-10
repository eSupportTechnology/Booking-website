<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTOs\SMS\SendSingleSMSDTO;
use App\Actions\SMS\SendSingleSMSAction;
use App\Services\OTPService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

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

        $success = $this->otpService->send($request->phone_number);

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

        $valid = $this->otpService->verify($request->phone_number, $request->otp);

        return response()->json([
            'success' => $valid,
            'message' => $valid ? 'OTP verified.' : 'Invalid OTP.'
        ]);
    }
}
