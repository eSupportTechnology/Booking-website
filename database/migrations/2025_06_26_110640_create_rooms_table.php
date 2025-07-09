<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
$table->id();
        $table->foreignId('property_id')->constrained('properties');
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('price_per_night', 10, 2);
        $table->integer('max_guests');
        $table->integer('bed_count');
        $table->integer('bathroom_count');
        $table->integer('size_sq_m')->nullable();
        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
