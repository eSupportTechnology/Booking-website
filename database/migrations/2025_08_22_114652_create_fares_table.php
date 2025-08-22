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
        Schema::create('fares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('taxi_id')->constrained('taxis')->cascadeOnDelete();
            $table->enum('fare_type', ['per_km', 'per_day']);
            $table->decimal('base_fare', 10, 2)->default(0);
            $table->decimal('price', 10, 2);
            $table->decimal('airport_fee', 10, 2)->nullable();
            $table->decimal('luggage_fee', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fares');
    }
};
