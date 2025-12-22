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
    Schema::create('car_reviews', function (Blueprint $table) {
        $table->id();

        $table->foreignId('reservation_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('car_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->tinyInteger('rating'); // 1–5
        $table->text('comment')->nullable();
        $table->text('reply')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_reviews');
    }
};
