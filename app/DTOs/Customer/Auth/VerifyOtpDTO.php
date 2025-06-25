<?php

namespace App\DTOs\Customer\Auth;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class VerifyOtpDTO extends ValidatedDTO
{
    public string $otp;

    protected function rules(): array
    {
        return [
            'otp' => ['required', 'string', 'size:6'],
        ];
    }
    protected function defaults(): array
    {
        return [
            'otp' => '',
        ];
    }
    protected function casts(): array
    {
        return [
            // 'otp' => 'string',
        ];
    }

}
