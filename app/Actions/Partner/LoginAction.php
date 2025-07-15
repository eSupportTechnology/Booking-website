<?php

namespace App\Actions\Partner;

use Illuminate\Support\Facades\Auth;

class LoginAction
{
    public function execute(string $email, string $password): bool
    {
        return Auth::attempt([
            'email' => $email,
            'password' => $password,
        ]);
    }
}
