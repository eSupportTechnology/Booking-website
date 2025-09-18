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
        Schema::table('cars', function (Blueprint $table) {
            // Add brand_id column as nullable
            $table->unsignedBigInteger('brand_id')->nullable()->after('model_id');

            // Set up foreign key relationship
            $table->foreign('brand_id')
                  ->references('id')
                  ->on('car_brands')
                  ->nullOnDelete(); // <-- If brand deleted, set brand_id to NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
        });
    }
};
