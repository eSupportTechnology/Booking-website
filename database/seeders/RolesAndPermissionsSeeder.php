<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        // $editArticles = Permission::updateOrCreate(['name' => 'edit articles']);
        // $deleteArticles = Permission::updateOrCreate(['name' => 'delete articles']);

        // Create roles
        $vendor = Role::updateOrCreate(['name' => 'vendor']);
        $partner = Role::updateOrCreate(['name' => 'partner']);

         // Assign permissions to roles
        // $vendor->givePermissionTo($editArticles);
        // $partner->givePermissionTo([$editArticles, $deleteArticles]);
    }
}
