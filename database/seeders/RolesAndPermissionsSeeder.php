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
            'view_dashboard',
            'view_customers',
            'edit_customers',
            'view_partners',
            'edit_partners',
            'view_rental_providers',
            'edit_rental_providers',
            'view_apartments',
            'edit_apartments',
            'view_homes',
            'edit_homes',
            'view_hotels',
            'edit_hotels',
            'view_alternative_places',
            'edit_alternative_places',
            'view_taxi',
            'edit_taxi',
            'approve_taxis',
            'reject_taxis',
            'view_airport',
            'edit_airport',
            'approve_cars',
            'reject_cars',
            'view_pending_admins',
            'view_admin_accounts',
            'manage_admin_permissions'
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
        $admin->syncPermissions(['view_dashboard', 'view_customers', 'view_partners']);
        $superAdmin->syncPermissions(Permission::where('guard_name', 'admin')->get());

        // Assign permissions to web roles
        $customer->syncPermissions(['book-property']);
        $partner->syncPermissions(['submit-property']);
    }
}