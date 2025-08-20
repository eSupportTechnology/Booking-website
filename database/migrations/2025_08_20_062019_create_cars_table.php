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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_type_id')->constrained('car_types')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('model_id')->constrained('car_models')->onDelete('cascade');

            $table->unsignedTinyInteger('seats');
            $table->enum('transmission', ['manual', 'automatic']);
            $table->enum('mileage_type', ['unlimited', 'limited']);
            $table->enum('pay_timing', ['now', 'later']);
            $table->enum('fuel_type', ['petrol', 'diesel', 'electric', 'hybrid']);
            $table->decimal('price_per_day', 10, 2);
            $table->decimal('deposit', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
