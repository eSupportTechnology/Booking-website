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
        // Check if user already exists (e.g., registered as customer)
        $existingUser = User::where('email', $dto->email)->first();

        if ($existingUser) {
            // Existing user - upgrade to partner
            $user = $existingUser;

            // Update password if provided (for security, they set new partner password)
            if ($dto->password) {
                $user->update([
                    'password' => Hash::make($dto->password),
                ]);
            }

            // Mark as partner
            $user->makePartner();
        } else {
            // New user - create fresh
            $user = User::create([
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => Hash::make($dto->password),
                'is_partner' => true,
            ]);
        }

        // Create partner record if not exists
        if (!$user->partner) {
            $user->partner()->create([
                'first_name' => $dto->first_name,
                'last_name' => $dto->last_name,
                'contact_number' => $dto->contact_number,
            ]);
        }

        // Assign role if using spatie/laravel-permission
        if (!$user->hasRole('partner')) {
            $user->assignRole('partner');
        }

        return $user;
    }
}
// This action handles the registration of a partner by creating a user and associated partner record.