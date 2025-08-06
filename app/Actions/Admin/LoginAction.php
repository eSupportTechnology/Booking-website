<?php

namespace App\Actions\Admin;

use App\DTOs\Admin\LoginDTO;
use Illuminate\Support\Facades\Auth;

class LoginAction
{
    public function execute(LoginDTO $dto): bool
    {
        return Auth::guard('admin')->attempt([
            'username' => $dto->username,
            'password' => $dto->password,
            'status' => 'approved'
        ], $dto->remember);
    }
}
