<?php

namespace App\Http\Requests;

use App\DTOs\Customer\VerifyOtpDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VerifyOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('customer')->check();
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'otp' => ['required', 'string', 'size:6']
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'otp.required' => 'Verification code is required.',
            'otp.string' => 'Verification code must be a string.',
            'otp.size' => 'Verification code must be exactly 6 characters.',
        ];
    }

    public function toDto(): VerifyOtpDto
    {
        return new VerifyOtpDto(
            email: $this->input('email'),
            otp: $this->input('otp'),
            userId: Auth::guard('customer')->id()
        );
    }
}
