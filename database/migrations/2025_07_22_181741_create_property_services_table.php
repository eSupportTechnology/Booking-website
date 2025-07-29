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
        Schema::create('property_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->boolean('serve_breakfast')->nullable();
            $table->string('breakfast_included')->nullable();
            $table->json('breakfast_type')->nullable();
            $table->string('breakfast_price')->nullable();
            $table->string('parking_available')->nullable();
            $table->decimal('parking_cost', 8, 2)->nullable();
            $table->string('parking_cost_unit')->nullable();
            $table->string('parking_reservation')->nullable();
            $table->string('parking_location')->nullable();
            $table->string('parking_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_services');
    }
};
