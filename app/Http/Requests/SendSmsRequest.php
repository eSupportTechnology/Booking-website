<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendSmsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone_number' => 'required|string|min:10|max:12',
            'message' => 'required|string|max:160',
            'sender_id' => 'nullable|string|max:11'
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.required' => 'Phone number is required',
            'phone_number.min' => 'Phone number must be at least 10 digits',
            'phone_number.max' => 'Phone number cannot exceed 12 digits',
            'message.required' => 'Message content is required',
            'message.max' => 'Message cannot exceed 160 characters',
            'sender_id.max' => 'Sender ID cannot exceed 11 characters'
        ];
    }
}
