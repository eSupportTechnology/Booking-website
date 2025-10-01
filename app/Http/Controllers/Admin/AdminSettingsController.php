<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $settings = $admin->settings;
        
        if (!$settings) {
            $settings = new AdminSettings([
                'admin_id' => $admin->id,
                'full_name' => $admin->username,
                'timezone' => 'UTC',
                'language' => 'en',
                'notification_preferences' => [
                    'email_alerts' => true,
                    'system_notifications' => true,
                    'security_alerts' => true,
                    'report_notifications' => false
                ],
                'commission_rate' => 0.15
            ]);
        }
        
        return view('admin.settings.index', compact('admin', 'settings'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . Auth::guard('admin')->id(),
            'phone' => 'nullable|string|max:20',
            'timezone' => 'required|string',
            'language' => 'required|string'
        ]);

        $admin = Auth::guard('admin')->user();
        
        // Update admin basic info
        $admin->update([
            'email' => $request->email
        ]);

        // Update or create settings
        $admin->settings()->updateOrCreate(
            ['admin_id' => $admin->id],
            [
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'timezone' => $request->timezone,
                'language' => $request->language
            ]
        );

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $admin = Auth::guard('admin')->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $admin->update([
            'password' => Hash::make($request->password)
        ]);

        $admin->settings()->updateOrCreate(
            ['admin_id' => $admin->id],
            ['last_password_change' => now()]
        );

        return back()->with('success', 'Password updated successfully.');
    }

    public function updateNotifications(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $notifications = [
            'email_alerts' => $request->boolean('email_alerts'),
            'system_notifications' => $request->boolean('system_notifications'),
            'security_alerts' => $request->boolean('security_alerts'),
            'report_notifications' => $request->boolean('report_notifications')
        ];

        $admin->settings()->updateOrCreate(
            ['admin_id' => $admin->id],
            ['notification_preferences' => $notifications]
        );

        return back()->with('success', 'Notification preferences updated successfully.');
    }

    public function toggleTwoFactor(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $admin->settings()->updateOrCreate(
            ['admin_id' => $admin->id],
            ['two_factor_enabled' => $request->boolean('enabled')]
        );

        $message = $request->boolean('enabled') ? 'Two-factor authentication enabled.' : 'Two-factor authentication disabled.';
        
        return back()->with('success', $message);
    }

    public function updateCommissionSettings(Request $request)
    {
        $request->validate([
            'commission_rate' => 'required|numeric|min:0|max:1'
        ]);

        $admin = Auth::guard('admin')->user();
        
        $admin->settings()->updateOrCreate(
            ['admin_id' => $admin->id],
            ['commission_rate' => $request->commission_rate]
        );

        return back()->with('success', 'Global commission rate updated successfully.');
    }

    public function commissionManagement()
    {
        return redirect()->route('admin.commission.index');
    }
}