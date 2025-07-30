<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminResetPasswordMail;

class AdminPasswordResetLinkController extends Controller
{
    /**
     * Handle an incoming password reset link request.
     */
    public function store(Request $request)
    {
        $request->validate(['username' => 'required|string']);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || !$admin->isApproved()) {
            return back()->with('error', 'No approved admin account found with this username.');
        }

        $token = Password::broker('admins')->createToken($admin);
        Mail::to($admin->email)->send(new AdminResetPasswordMail($token, $admin->email));

        return back()->with('success', 'Password reset link has been sent to your email address.');
    }
}