<?php

namespace App\Actions\Admin;

use App\DTOs\Admin\ForgotPasswordDTO;
use Illuminate\Support\Facades\Password;

class ForgotPasswordAction
{
    public function execute(ForgotPasswordDTO $dto): string
    {
        return Password::sendResetLink(['email' => $dto->email]);
    }
}