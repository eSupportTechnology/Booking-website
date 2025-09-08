<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('taxis', function (Blueprint $table) {
            $table->enum('status', ['Active', 'Inactive', 'On Trip'])->default('Inactive')->after('luggage_capacity');
        });
    }

    public function down(): void
    {
        Schema::table('taxis', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
