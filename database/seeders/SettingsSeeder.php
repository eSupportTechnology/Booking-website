<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use App\Models\AdminSettings;
use App\Models\PartnerSettings;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin settings for existing admins
        Admin::whereDoesntHave('settings')->each(function ($admin) {
            AdminSettings::create([
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
                'two_factor_enabled' => false
            ]);
        });

        // Create default partner settings for existing partners
        User::whereHas('partner')->whereDoesntHave('partner.settings')->each(function ($user) {
            PartnerSettings::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'timezone' => 'UTC',
                'language' => 'en',
                'currency' => 'USD',
                'notification_preferences' => [
                    'email_bookings' => true,
                    'email_messages' => true,
                    'email_reviews' => false,
                    'email_payments' => true,
                    'sms_urgent' => false,
                    'sms_issues' => true
                ],
                'payout_settings' => [
                    'payout_frequency' => 'monthly',
                    'minimum_payout' => 100
                ],
                'two_factor_enabled' => false
            ]);
        });
    }
}