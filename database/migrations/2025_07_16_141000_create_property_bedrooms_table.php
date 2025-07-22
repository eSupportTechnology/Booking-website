<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('property_bedrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->string('room_type'); // e.g., 'bedroom', 'living_room', 'other'
            $table->string('name'); // e.g., 'Bedroom 1', 'Living room'
            $table->unsignedInteger('twin')->default(0);
            $table->unsignedInteger('full')->default(0);
            $table->unsignedInteger('queen')->default(0);
            $table->unsignedInteger('king')->default(0);
            $table->unsignedInteger('bunk')->default(0);
            $table->unsignedInteger('sofa')->default(0);
            $table->unsignedInteger('futon')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_bedrooms');
    }
}; 