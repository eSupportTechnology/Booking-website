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
        Schema::table('car_renters', function (Blueprint $table) {
            $table->unsignedTinyInteger('discount_percentage')
                ->nullable()
                ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('car_renters', function (Blueprint $table) {
            $table->dropColumn('discount_percentage');
        });
    }
};
