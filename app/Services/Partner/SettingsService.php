<?php

namespace App\Services\Partner;

use Illuminate\Support\Facades\Auth;

class SettingsService
{
    public function getProfile(): array
    {
        $user = Auth::user();
        
        return [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '',
            'language' => 'English',
            'bio' => $user->bio ?? ''
        ];
    }

    public function getNotificationSettings(): array
    {
        return [
            'email_bookings' => true,
            'email_messages' => true,
            'email_reviews' => false,
            'email_payments' => true,
            'sms_urgent' => false,
            'sms_issues' => true
        ];
    }

    public function getSecuritySettings(): array
    {
        return [
            'two_factor_enabled' => false,
            'last_password_change' => '2024-01-15',
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
}