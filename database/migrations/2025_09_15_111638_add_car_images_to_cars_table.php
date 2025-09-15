<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      public function up() {
        Schema::table('cars', function (Blueprint $table) {
            $table->string('car_front')->nullable();
            $table->string('car_back')->nullable();
            $table->string('car_inside')->nullable();
        });
    }

    public function down() {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['car_front', 'car_back', 'car_inside']);
        });
    }
};
