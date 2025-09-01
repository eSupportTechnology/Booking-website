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
        Schema::create('property_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->enum('booking_type', ['instant', 'request'])->default('instant');
            $table->decimal('price_per_night', 10, 2)->nullable();
            $table->enum('currency', ['usd', 'eur', 'gbp'])->default('usd');
            $table->boolean('discount_enabled')->default(false);
            $table->integer('discount_percent')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_pricings');
    }
};
