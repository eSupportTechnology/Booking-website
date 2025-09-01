<?php

namespace App\Actions\CarRenters;

use Illuminate\Support\Facades\Auth;

class LoginAction
{
    public function execute(string $email, string $password): bool
    {
        return Auth::guard('car_renter')->attempt([
            'email' => $email,
            'password' => $password,
        ]);
    }
}
