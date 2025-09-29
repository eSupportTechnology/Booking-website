<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class AdminPermissionController extends Controller
{
    public function show(Admin $admin)
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        if (!$currentAdmin->isSuperAdmin() && !$currentAdmin->can('manage_admin_permissions')) {
            abort(403, 'You do not have permission to manage admin permissions.');
        }
        
        $permissions = Permission::where('guard_name', 'admin')->get()->groupBy(function($permission) {
            if (str_contains($permission->name, 'dashboard')) return 'Dashboard';
            if (str_contains($permission->name, 'customer') || str_contains($permission->name, 'partner')) return 'Users';
            if (str_contains($permission->name, 'apartment') || str_contains($permission->name, 'home') || 
                str_contains($permission->name, 'hotel') || str_contains($permission->name, 'alternative')) return 'Property';
            if (str_contains($permission->name, 'taxi') || str_contains($permission->name, 'airport') || 
                str_contains($permission->name, 'car') || str_contains($permission->name, 'rental_provider')) return 'Rental';
            if (str_contains($permission->name, 'admin')) return 'Admin Management';
            return 'Other';
        });

        $adminPermissions = $admin->permissions->pluck('name')->toArray();

        return view('admin.permissions.manage', compact('admin', 'permissions', 'adminPermissions'));
    }

    public function update(Request $request, Admin $admin)
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        if (!$currentAdmin->isSuperAdmin() && !$currentAdmin->can('manage_admin_permissions')) {
            abort(403, 'You do not have permission to manage admin permissions.');
        }
        
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name'
        ]);

        // Sync permissions
        $admin->syncPermissions($request->permissions ?? []);

        return redirect()->back()->with('success', 'Admin permissions updated successfully!');
    }
}