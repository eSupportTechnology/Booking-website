<?php
namespace App\Services\Admin;
use App\Models\Admin;
class AdminAccountService
{
    public function getAllAdminAccounts($superAdminId)
    {
        return Admin::where('id', '!=', $superAdminId)
                   ->orderBy('created_at', 'desc')
                   ->get();
    }
    public function updateAdminStatus($id, $status)
    {
        $admin = Admin::findOrFail($id);
        $admin->status = $status;
        $admin->approved_by = auth('admin')->id();
        $admin->approved_at = now();
        $admin->save();
        return $admin;
    }
}
