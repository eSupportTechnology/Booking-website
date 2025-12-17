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
        Schema::create('vehicle_type_commissions', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('car_renter_id');
    $table->unsignedBigInteger('vehicle_type_id');
    $table->decimal('commission_rate', 5, 2)->nullable(); // percent
    $table->timestamps();

    $table->unique(['car_renter_id', 'vehicle_type_id']);
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_type_commissions');
    }
};
