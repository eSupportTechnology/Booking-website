<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('taxis', function (Blueprint $table) {
            $table->foreignId('car_renter_id')->nullable()->after('taxi_type_id')->constrained('car_renters')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('taxis', function (Blueprint $table) {
            $table->dropForeign(['car_renter_id']);
            $table->dropColumn('car_renter_id');
        });
    }
};