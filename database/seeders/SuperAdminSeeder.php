<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@booking.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('SuperAdmin123!'),
                'email_verified_at' => now()
            ]
        );

        $superAdmin->assignRole('super-admin');
    }
}