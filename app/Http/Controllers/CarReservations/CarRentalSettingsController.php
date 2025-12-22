<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CarRentalSettingsController extends Controller
{
    public function index()
    {
        $user = Auth::guard('car_renter')->user();

        return view('car_rentals.settings.index', [
            'profile' => [
                'name' => $user->full_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'language' => $user->language ?? 'English',
                'timezone' => $user->timezone ?? 'UTC',
                'currency' => $user->currency ?? 'USD',
                'bio' => $user->bio,
            ],
            'notifications' => [
                'email_bookings' => true,
                'email_messages' => true,
                'email_reviews' => true,
                'email_payments' => true,
                'sms_urgent' => false,
                'sms_issues' => false,
            ],
            'security' => [
                'two_factor_enabled' => false,
                'active_sessions' => [],
            ],
            'payout' => [
                'bank_name' => '',
                'account_number' => '',
                'account_holder' => '',
                'swift_code' => '',
                'payout_frequency' => 'monthly',
                'minimum_payout' => 100,
            ],
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('car_renter')->user();

        $user->update($request->only([
            'full_name','email','phone','language','timezone','currency','bio'
        ]));

        return back()->with('success', 'Profile updated');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = Auth::guard('car_renter')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Wrong password']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated');
    }

    public function updateNotifications(Request $request)
    {
        // Save to settings table or JSON column
        return back()->with('success', 'Notifications updated');
    }

    public function updatePayout(Request $request)
    {
        // Save payout details
        return back()->with('success', 'Payout updated');
    }

    public function toggleTwoFactor(Request $request)
    {
        // Enable / disable 2FA
        return back()->with('success', '2FA updated');
    }
}
