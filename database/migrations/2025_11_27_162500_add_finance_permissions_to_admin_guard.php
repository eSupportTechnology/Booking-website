<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permissions = [
            'view_payouts',
            'view_commission_aging',
            'view_aging_report',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'admin']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permissions = [
            'view_payouts',
            'view_commission_aging',
            'view_aging_report',
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->where('guard_name', 'admin')->delete();
        }
    }
};
