<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeederForAdmins extends Seeder
{
    public function run(): void
    {
        // Ensure the role exists for the admin guard
        $role = Role::firstOrCreate([
            'name' => 'superAdmin',
            'guard_name' => 'admin', // Must match guard used by Admin model
        ]);

        // Create or update the super admin user
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

        // Assign the role to the super admin
        $superAdmin->assignRole($role); // safer than assignRole('superAdmin')
    }
}
