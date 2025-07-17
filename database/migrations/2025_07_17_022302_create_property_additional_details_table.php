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
        Schema::create('property_additional_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->integer('guests')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->string('allow_children')->nullable();
            $table->string('offer_cribs')->nullable();
            $table->integer('apartment_size')->nullable();
            $table->string('apartment_unit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_additional_details');
    }
};
