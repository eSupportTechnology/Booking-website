<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('taxis', function (Blueprint $table) {
            $table->string('front_image')->nullable()->after('luggage_capacity');
            $table->string('back_image')->nullable()->after('front_image');
            $table->string('inside_image')->nullable()->after('back_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('taxis', function (Blueprint $table) {
            $table->dropColumn(['front_image', 'back_image', 'inside_image']);
        });
    }
};