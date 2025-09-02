<?php

namespace App\Actions\CarRenters;

use Illuminate\Support\Facades\Auth;

class LoginAction
{
    /**
     * Try to login the car renter using the car_renter guard.
     *
     * @param string $email
     * @param string $password
     * @param bool $remember
     * @return bool
     */
    public function execute(string $email, string $password, bool $remember = false): bool
    {
        // Make sure you have the 'car_renter' guard configured (see config/auth.php)
        return Auth::guard('car_renter')->attempt([
            'email' => $email,
            'password' => $password,
        ], $remember);
    }
}
