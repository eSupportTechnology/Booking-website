<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        // Create admin permissions
        $permissions = [
            // Dashboard
            'view_dashboard',
            
            // Users
            'view_customers',
            'edit_customers',
            'activate_customers',
            'deactivate_customers',
            'view_partners',
            'edit_partners',
            'activate_partners',
            'deactivate_partners',
            
            // Property Management
            'view_apartments',
            'edit_apartments',
            'change_apartment_status',
            'view_homes',
            'edit_homes',
            'change_home_status',
            'view_hotels',
            'edit_hotels',
            'change_hotel_status',
            'view_alternative_places',
            'edit_alternative_places',
            'change_alternative_status',
            
            // Rental Management
            'view_taxi',
            'edit_taxi',
            'change_taxi_status',
            'view_airport',
            'edit_airport',
            'change_airport_status',
            
            // Admin Management
            'view_pending_admins',
            'approve_admins',
            'reject_admins',
            'view_admin_accounts',
            'edit_admin_accounts',
            'manage_admin_permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin'
            ]);
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'admin'
        ]);

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'admin'
        ]);

        // Assign all permissions to super admin
        $superAdminRole->syncPermissions(Permission::where('guard_name', 'admin')->get());
    }

    public function down(): void
    {
        Permission::where('guard_name', 'admin')->delete();
        Role::where('guard_name', 'admin')->delete();
    }
};