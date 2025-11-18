<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('reservations', function (Blueprint $table) {
        $table->string('pickup_location')->nullable();
        $table->string('dropoff_location')->nullable();
        $table->dateTime('pickup_datetime')->nullable();
        $table->dateTime('dropoff_datetime')->nullable();
        $table->enum('payment_status', ['pending', 'paid'])->default('pending');
        $table->text('notes')->nullable();
    });
}

public function down()
{
    Schema::table('reservations', function (Blueprint $table) {
        $table->dropColumn([
            'pickup_location', 'dropoff_location',
            'pickup_datetime', 'dropoff_datetime',
            'payment_status', 'notes'
        ]);
    });
}

};
