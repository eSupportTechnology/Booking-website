<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('cars', function (Blueprint $table) {
            $table->string('driver_license_front')->nullable();
            $table->string('driver_license_back')->nullable();
        });
    }

    public function down() {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['driver_license_front', 'driver_license_back']);
        });
    }
};