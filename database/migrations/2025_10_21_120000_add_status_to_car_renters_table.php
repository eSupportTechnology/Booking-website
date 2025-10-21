<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('car_renters', function (Blueprint $table) {
            // default to pending for existing records
            $table->enum('status', ['active', 'suspended', 'pending'])->default('pending')->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('car_renters', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
