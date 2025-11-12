<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->decimal('fixed_discount_amount', 10, 2)->nullable()->after('discounted_price');
            $table->string('special_offer_text')->nullable()->after('fixed_discount_amount');
            $table->enum('applicable_to', ['property', 'room'])->default('property')->after('special_offer_text');
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('cascade')->after('property_id');
        });
    }

    public function down()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->dropColumn(['fixed_discount_amount', 'special_offer_text', 'applicable_to']);
            $table->dropForeign(['room_id']);
            $table->dropColumn('room_id');
        });
    }
};