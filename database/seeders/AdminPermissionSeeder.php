<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Spatie\Permission\Models\Role;

class AdminPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Find or create super admin
        $superAdmin = Admin::where('email', 'superadmin@booking.com')->first();
        
        if (!$superAdmin) {
            $superAdmin = Admin::create([
                'username' => 'superadmin',
                'email' => 'superadmin@booking.com',
                'password' => bcrypt('password123'),
                'status' => 'approved',
                'approved_at' => now()
            ]);
        }

        // Assign super admin role
        $superAdminRole = Role::where('name', 'super_admin')->where('guard_name', 'admin')->first();
        if ($superAdminRole) {
            $superAdmin->assignRole($superAdminRole);
        }
    }
}