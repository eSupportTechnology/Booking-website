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
            $table->integer('bed_count')->default(1);
            $table->integer('bathroom_count');
            $table->enum('bathroom_type', ['private', 'shared'])->nullable();
            $table->json('bathroom_amenities')->nullable();
            $table->integer('size_sq_m')->nullable();
            $table->boolean('smoking_allowed')->default(false);
            

            $table->string('currency', 5)->nullable()->default('usd');
            $table->boolean('discount_enabled')->default(false);
            $table->decimal('commission_percentage', 5, 2)->default(15);
            $table->decimal('you_earn', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
