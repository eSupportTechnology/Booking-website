<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('deal_id')->nullable()->constrained()->onDelete('set null')->after('room_id');
            $table->decimal('original_price', 10, 2)->nullable()->after('total_price');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('original_price');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['deal_id']);
            $table->dropColumn(['deal_id', 'original_price', 'discount_amount']);
        });
    }
};