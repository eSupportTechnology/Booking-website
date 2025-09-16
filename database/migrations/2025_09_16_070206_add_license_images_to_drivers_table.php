<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            // Driver license images
            $table->string('driver_license_front')->nullable()->after('photo');
            $table->string('driver_license_back')->nullable()->after('driver_license_front');

            // Tourism license images
            $table->string('tourism_license_front')->nullable()->after('driver_license_back');
            $table->string('tourism_license_back')->nullable()->after('tourism_license_front');
        });
    }

    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn([
                'driver_license_front',
                'driver_license_back',
                'tourism_license_front',
                'tourism_license_back'
            ]);
        });
    }
};
