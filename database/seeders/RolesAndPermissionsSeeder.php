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

        // Create roles
        $customer = Role::updateOrCreate(['name' => 'customer']);
        $partner = Role::updateOrCreate(['name' => 'partner']);
        $admin = Role::updateOrCreate(['name' => 'admin']);
        $superAdmin = Role::updateOrCreate(['name' => 'superAdmin']);

        // Create permissions
        $permissions = [
            'manage-users',
            'manage-properties',
            'manage-bookings',
            'view-dashboard',
            'manage-admins'
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $admin->givePermissionTo(['manage-users', 'manage-properties', 'manage-bookings', 'view-dashboard']);
        $superAdmin->givePermissionTo(Permission::all());
    }
}
