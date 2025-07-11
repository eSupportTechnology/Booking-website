<?php

namespace App\Http\Requests;

use App\DTOs\Customer\SendOtpDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SendOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('customer')->check();
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255']
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Please enter a valid email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address must not exceed 255 characters.',
        ];
    }

    public function toDto(): SendOtpDto
    {
        return new SendOtpDto(
            email: $this->input('email'),
            userId: Auth::guard('customer')->id()
        );
    }
}
