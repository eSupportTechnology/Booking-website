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
        Schema::create('taxi_driver', function (Blueprint $table) {
            $table->id();
            $table->foreignId('taxi_id')->constrained('taxis')->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnDelete();
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamp('released_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxi_driver');
    }
};
