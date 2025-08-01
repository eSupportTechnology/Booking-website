<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for admin guard
        $adminPermissions = [
            'manage-users',
            'manage-properties', 
            'manage-bookings',
            'view-dashboard',
            'manage-admins'
        ];

        foreach ($adminPermissions as $permission) {
            Permission::updateOrCreate([
                'name' => $permission,
                'guard_name' => 'admin'
            ]);
        }

        // Create permissions for web guard
        $webPermissions = [
            'book-property',
            'submit-property'
        ];

        foreach ($webPermissions as $permission) {
            Permission::updateOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Create roles for admin guard
        $admin = Role::updateOrCreate([
            'name' => 'admin',
            'guard_name' => 'admin'
        ]);
        
        $superAdmin = Role::updateOrCreate([
            'name' => 'superAdmin',
            'guard_name' => 'admin'
        ]);

        // Create roles for web guard
        $customer = Role::updateOrCreate([
            'name' => 'customer',
            'guard_name' => 'web'
        ]);
        
        $partner = Role::updateOrCreate([
            'name' => 'partner',
            'guard_name' => 'web'
        ]);

        // Assign permissions to admin roles
        $admin->syncPermissions(['manage-users', 'manage-properties', 'manage-bookings', 'view-dashboard']);
        $superAdmin->syncPermissions(Permission::where('guard_name', 'admin')->get());

        // Assign permissions to web roles
        $customer->syncPermissions(['book-property']);
        $partner->syncPermissions(['submit-property']);
    }
}