<?php

namespace App\Actions\Admin;

use App\DTOs\Admin\RegisterDTO;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
    public function execute(RegisterDTO $dto): Admin
    {
        $admin = Admin::create([
            'username' => $dto->username,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'status' => 'pending',
            'email_verified_at' => now()
        ]);

        $admin->assignRole('admin');

        return $admin;
    }
}