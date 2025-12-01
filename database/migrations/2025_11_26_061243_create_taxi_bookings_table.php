<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('taxi_bookings', function (Blueprint $table) {
            $table->id();

            // Booking Reference
            $table->string('booking_id')->unique();

            // User
            $table->unsignedBigInteger('user_id')->nullable();

            // Taxi + Driver
            $table->unsignedBigInteger('taxi_id')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();

            // Trip information
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->datetime('pickup_datetime');
            $table->datetime('return_datetime')->nullable();
            $table->decimal('distance', 10, 2)->nullable();

            // Fare breakdown
            $table->decimal('base_fare', 10, 2)->default(0);
            $table->decimal('distance_fare', 10, 2)->default(0);
            $table->decimal('service_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);

            // Customer details
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('email');
            $table->string('phone1');
            $table->string('phone2')->nullable();

            // Payment
            $table->enum('payment_method', [
                'card','paypal','stripe','bank_transfer','pay_to_driver'
            ])->default('pay_to_driver');

            $table->enum('payment_status', [
                'pending','paid','failed'
            ])->default('pending');

            // Booking status
            $table->enum('status', [
                'pending','confirmed','cancelled','completed'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taxi_bookings');
    }
};
