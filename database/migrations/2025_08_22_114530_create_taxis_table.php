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
        Schema::create('taxis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('taxi_type_id')->constrained('taxi_types')->cascadeOnDelete();
            $table->string('number_plate')->unique()->nullable();
            $table->string('color')->nullable();
            $table->integer('passenger_capacity')->nullable();
            $table->integer('luggage_capacity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxis');
    }
};
