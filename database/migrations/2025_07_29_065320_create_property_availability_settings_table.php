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
        Schema::create('property_availability_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            
            // Availability mode settings
            $table->enum('availability_mode', ['continuous', '18months'])->default('continuous');
            $table->integer('availability_days')->default(365); // 30, 90, 180, 365 days
            
            // Long stay settings
            $table->boolean('allow_long_stays')->nullable();
            $table->integer('max_nights')->nullable(); // Maximum nights for long stays (31-90)
            
            // TripAdvisor sync
            $table->boolean('sync_tripadvisor')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_availability_settings');
    }
};
