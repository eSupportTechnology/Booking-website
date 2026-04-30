<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds role flags to users table to support multi-role accounts.
     * A single user can be a customer, partner, and/or car renter.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_partner')->default(false)->after('email');
            $table->boolean('is_car_renter')->default(false)->after('is_partner');
        });

        // Mark existing users who have partner records
        $partnerUserIds = DB::table('partners')->pluck('user_id')->toArray();
        if (!empty($partnerUserIds)) {
            DB::table('users')
                ->whereIn('id', $partnerUserIds)
                ->update(['is_partner' => true]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_partner', 'is_car_renter']);
        });
    }
};
