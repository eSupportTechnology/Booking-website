<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminApprovalController extends Controller
{
    public function index()
    {
        $pendingAdmins = Admin::where('status', 'pending')->get();
        return view('admin.approvals.index', compact('pendingAdmins'));
    }

    public function approve(Admin $admin)
    {
        $admin->update([
            'status' => 'approved',
            'approved_by' => Auth::guard('admin')->id(),
            'approved_at' => now()
        ]);

        // Assign basic admin role
        $admin->assignRole('admin');

        return redirect()->route('admin.permissions.manage', $admin)
            ->with('success', 'Admin approved successfully! Please configure permissions.');
    }

    public function reject(Admin $admin)
    {
        $admin->update([
            'status' => 'rejected',
            'approved_by' => Auth::guard('admin')->id(),
            'approved_at' => now()
        ]);

        return back()->with('success', 'Admin rejected successfully!');
    }
}