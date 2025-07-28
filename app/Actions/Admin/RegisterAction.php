<?php

namespace App\Actions\Admin;

use App\DTOs\Admin\RegisterDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
    public function execute(RegisterDTO $dto): User
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'email_verified_at' => now()
        ]);

        $user->assignRole('admin');

        return $user;
    }
}