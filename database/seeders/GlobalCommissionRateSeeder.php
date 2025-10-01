<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminSettings;
use App\Models\Admin;

class GlobalCommissionRateSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first admin or create a default one
        $admin = Admin::first();
        
        if ($admin) {
            // Create or update admin settings with default commission rate
            AdminSettings::updateOrCreate(
                ['admin_id' => $admin->id],
                ['commission_rate' => 0.15] // 15% default commission rate
            );
        }
    }
}