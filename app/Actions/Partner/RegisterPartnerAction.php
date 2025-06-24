<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\RegisterPartnerDTO;
use App\Models\User;
use App\Models\Partner;
use Illuminate\Support\Facades\Hash;

class RegisterPartnerAction
{
    public function execute(RegisterPartnerDTO $dto): User
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);

        $user->partner()->create([
            'first_name' => $dto->first_name,
            'last_name' => $dto->last_name,
            'contact_number' => $dto->contact_number,
        ]);

        $user->assignRole('partner'); // optional if you're using spatie/laravel-permission

        return $user;
    }
}
// This action handles the registration of a partner by creating a user and associated partner record.