<?php

// app/Services/Admin/AdminAccountService.php
namespace App\Services\Admin;
use App\Models\Admin;
class AdminAccountService
{
    public function getAllAdminAccounts($superAdminId)
    {
        // Fetch all admin accounts excluding the super admin account
        return Admin::where('id', '!=', $superAdminId)->get();
    }
    public function toggleAdminStatus($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->status = !$admin->status; // Toggle active status
        $admin->save();
    }
}
