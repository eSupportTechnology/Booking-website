<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminRolesSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles for admin guard
        $admin = Role::updateOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $superAdmin = Role::updateOrCreate(['name' => 'super-admin', 'guard_name' => 'admin']);

        // Create permissions for admin guard
        $permissions = [
            'manage-users',
            'manage-properties', 
            'manage-bookings',
            'view-dashboard',
            'manage-admins'
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission, 'guard_name' => 'admin']);
        }

        // Assign permissions
        $admin->givePermissionTo(['manage-users', 'manage-properties', 'manage-bookings', 'view-dashboard']);
        $superAdmin->givePermissionTo(Permission::where('guard_name', 'admin')->get());
    }
}