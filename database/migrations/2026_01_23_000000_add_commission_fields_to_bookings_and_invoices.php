<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add booking_id to commission_invoices table
        Schema::table('commission_invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id')->nullable()->after('partner_id');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });

        // Add commission fields to bookings table
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('commission_rate', 5, 2)->default(10.00)->after('total_price');
            $table->decimal('commission_amount', 10, 2)->default(0.00)->after('commission_rate');
            $table->enum('commission_status', ['pending', 'invoiced', 'paid', 'cancelled'])->default('pending')->after('commission_amount');
        });
    }

    public function down()
    {
        Schema::table('commission_invoices', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->dropColumn('booking_id');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['commission_rate', 'commission_amount', 'commission_status']);
        });
    }
};