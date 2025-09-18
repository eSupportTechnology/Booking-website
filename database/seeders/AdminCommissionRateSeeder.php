<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AdminSettings;
use Illuminate\Database\Seeder;

class AdminCommissionRateSeeder extends Seeder
{
    public function run(): void
    {
        // Update existing admin settings to include commission rate
        $admins = Admin::all();
        
        foreach ($admins as $admin) {
            AdminSettings::updateOrCreate(
                ['admin_id' => $admin->id],
                ['commission_rate' => 0.15] // Default 15%
            );
        }
        
        $this->command->info('Commission rate seeded for ' . $admins->count() . ' admin(s)');
    }
}