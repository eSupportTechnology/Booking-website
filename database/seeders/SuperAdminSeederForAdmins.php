<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeederForAdmins extends Seeder
{
    public function run(): void
    {
        $superAdmin = Admin::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'email' => 'superadmin@booking.com',
                'password' => Hash::make('SuperAdmin123!'),
                'status' => 'approved',
                'email_verified_at' => now(),
                'approved_at' => now()
            ]
        );

        $superAdmin->assignRole('super-admin');
    }
}