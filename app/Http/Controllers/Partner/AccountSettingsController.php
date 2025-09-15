<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\PartnerSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountSettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $settings = $user->partner->settings ?? new PartnerSettings();
        
        return view('partner.settings.account', compact('user', 'settings'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'language' => 'required|string',
            'timezone' => 'required|string',
            'currency' => 'required|string'
        ]);

        $user = Auth::user();
        
        // Update user basic info
        $user->update([
            'name' => $request->full_name,
            'email' => $request->email
        ]);

        // Update partner settings
        $user->partner->settings()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'bio' => $request->bio,
                'language' => $request->language,
                'timezone' => $request->timezone,
                'currency' => $request->currency
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

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        $user->partner->settings()->updateOrCreate(
            ['user_id' => $user->id],
            ['last_password_change' => now()]
        );

        return back()->with('success', 'Password updated successfully.');
    }

    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        $notifications = [
            'email_bookings' => $request->boolean('email_bookings'),
            'email_messages' => $request->boolean('email_messages'),
            'email_reviews' => $request->boolean('email_reviews'),
            'email_payments' => $request->boolean('email_payments'),
            'sms_urgent' => $request->boolean('sms_urgent'),
            'sms_issues' => $request->boolean('sms_issues')
        ];

        $user->partner->settings()->updateOrCreate(
            ['user_id' => $user->id],
            ['notification_preferences' => $notifications]
        );

        return back()->with('success', 'Notification preferences updated successfully.');
    }

    public function updatePayout(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:255',
            'swift_code' => 'required|string|max:20',
            'payout_frequency' => 'required|in:weekly,bi-weekly,monthly',
            'minimum_payout' => 'required|numeric|min:50'
        ]);

        $user = Auth::user();
        
        $payoutSettings = [
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
            'swift_code' => $request->swift_code,
            'payout_frequency' => $request->payout_frequency,
            'minimum_payout' => $request->minimum_payout
        ];

        $user->partner->settings()->updateOrCreate(
            ['user_id' => $user->id],
            ['payout_settings' => $payoutSettings]
        );

        return back()->with('success', 'Payout settings updated successfully.');
    }

    public function toggleTwoFactor(Request $request)
    {
        $user = Auth::user();
        
        $user->partner->settings()->updateOrCreate(
            ['user_id' => $user->id],
            ['two_factor_enabled' => $request->boolean('enabled')]
        );

        $message = $request->boolean('enabled') ? 'Two-factor authentication enabled.' : 'Two-factor authentication disabled.';
        
        return back()->with('success', $message);
    }
}