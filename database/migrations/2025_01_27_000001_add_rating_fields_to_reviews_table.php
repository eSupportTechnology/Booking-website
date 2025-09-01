<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->decimal('staff_rating', 2, 1)->nullable()->after('rating');
            $table->decimal('facilities_rating', 2, 1)->nullable()->after('staff_rating');
            $table->decimal('cleanliness_rating', 2, 1)->nullable()->after('facilities_rating');
            $table->decimal('comfort_rating', 2, 1)->nullable()->after('cleanliness_rating');
            $table->decimal('value_rating', 2, 1)->nullable()->after('comfort_rating');
            $table->decimal('location_rating', 2, 1)->nullable()->after('value_rating');
            $table->decimal('wifi_rating', 2, 1)->nullable()->after('location_rating');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn([
                'staff_rating',
                'facilities_rating', 
                'cleanliness_rating',
                'comfort_rating',
                'value_rating',
                'location_rating',
                'wifi_rating'
            ]);
        });
    }
};