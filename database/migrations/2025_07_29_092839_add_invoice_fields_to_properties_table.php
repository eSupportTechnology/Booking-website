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
        Schema::table('properties', function (Blueprint $table) {
            $table->json('invoicing_info')->nullable()->after('status');
            $table->enum('payment_method', ['online', 'credit'])->nullable()->after('invoicing_info');
            $table->boolean('open_for_bookings')->default(false)->after('invoicing_info');
        });
    }

    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('invoicing_info');
            $table->dropColumn('open_for_bookings');
        });
    }
};
