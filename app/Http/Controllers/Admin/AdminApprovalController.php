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

        return back()->with('success', 'Admin approved successfully!');
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