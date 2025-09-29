<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        $permissions = [
            'view_rental_providers',
            'edit_rental_providers',
            'approve_cars',
            'reject_cars',
            'approve_taxis',
            'reject_taxis',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin'
            ]);
        }

        // Assign new permissions to super admin role
        $superAdminRole = Role::where('name', 'super_admin')->where('guard_name', 'admin')->first();
        if ($superAdminRole) {
            $superAdminRole->syncPermissions(Permission::where('guard_name', 'admin')->get());
        }
    }

    public function down(): void
    {
        Permission::whereIn('name', [
            'view_rental_providers',
            'edit_rental_providers', 
            'approve_cars',
            'reject_cars',
            'approve_taxis',
            'reject_taxis',
        ])->where('guard_name', 'admin')->delete();
    }
};