<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Actions\Customer\SendEmailOtpAction;
use App\Actions\Customer\VerifyEmailOtpAction;
use App\Actions\Customer\ResendEmailOtpAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
    public function __construct(
        private SendEmailOtpAction $queuedSendEmailOtpAction,
        private VerifyEmailOtpAction $verifyEmailOtpAction,
        private ResendEmailOtpAction $queuedResendEmailOtpAction
    ) {}

    public function sendOtp(SendOtpRequest $request): JsonResponse
    {
        $result = $this->queuedSendEmailOtpAction->execute($request->toDto());

        return response()->json($result->toArray(), $result->getStatusCode());
    }

    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        $result = $this->verifyEmailOtpAction->execute($request->toDto());

        return response()->json($result->toArray(), $result->getStatusCode());
    }

    public function resendOtp(Request $request): JsonResponse
    {
        $result = $this->queuedResendEmailOtpAction->execute($request->input('email'));

        return response()->json($result->toArray(), $result->getStatusCode());
    }
}
