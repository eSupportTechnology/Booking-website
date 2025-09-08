<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('car_renters', function (Blueprint $table) {
            $table->string('tin_number')->nullable()->after('business_reg_no'); 
            $table->string('phone2')->nullable()->after('phone'); 
        });
    }

    public function down(): void
    {
        Schema::table('car_renters', function (Blueprint $table) {
            $table->dropColumn(['tin_number', 'phone2']);
        });
    }
};
