<?php

namespace App\Services\Partner;

use Illuminate\Support\Facades\Auth;

class SettingsService
{
    public function getProfile(): array
    {
        $user = Auth::user();
        $settings = $user->partner->settings ?? null;
        
        return [
            'name' => $settings->full_name ?? $user->name ?? '',
            'email' => $user->email ?? '',
            'phone' => $settings->phone ?? '',
            'language' => $settings->language ?? 'English',
            'bio' => $settings->bio ?? '',
            'timezone' => $settings->timezone ?? 'UTC',
            'currency' => $settings->currency ?? 'USD'
        ];
    }

    public function getNotificationSettings(): array
    {
        $user = Auth::user();
        $settings = $user->partner->settings ?? null;
        $preferences = $settings->notification_preferences ?? [];
        
        return [
            'email_bookings' => $preferences['email_bookings'] ?? true,
            'email_messages' => $preferences['email_messages'] ?? true,
            'email_reviews' => $preferences['email_reviews'] ?? false,
            'email_payments' => $preferences['email_payments'] ?? true,
            'sms_urgent' => $preferences['sms_urgent'] ?? false,
            'sms_issues' => $preferences['sms_issues'] ?? true
        ];
    }

    public function getSecuritySettings(): array
    {
        $user = Auth::user();
        $settings = $user->partner->settings ?? null;
        
        return [
            'two_factor_enabled' => $settings->two_factor_enabled ?? false,
            'last_password_change' => $settings->last_password_change?->format('Y-m-d') ?? 'Never',
            'active_sessions' => [
                [
                    'device' => 'Windows PC - Chrome',
                    'location' => 'New York, US',
                    'status' => 'current',
                    'last_active' => 'Now'
                ],
                [
                    'device' => 'iPhone - Safari',
                    'location' => 'New York, US',
                    'status' => 'active',
                    'last_active' => '2 hours ago'
                ]
            ]
        ];
    }

    public function getPayoutSettings(): array
    {
        $user = Auth::user();
        $settings = $user->partner->settings ?? null;
        $payout = $settings->payout_settings ?? [];
        
        return [
            'bank_name' => $payout['bank_name'] ?? '',
            'account_number' => $payout['account_number'] ?? '',
            'account_holder' => $payout['account_holder'] ?? '',
            'swift_code' => $payout['swift_code'] ?? '',
            'payout_frequency' => $payout['payout_frequency'] ?? 'monthly',
            'minimum_payout' => $payout['minimum_payout'] ?? 100
        ];
    }
}