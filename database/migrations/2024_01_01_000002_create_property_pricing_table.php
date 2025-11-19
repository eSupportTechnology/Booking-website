<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('property_pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->decimal('adult_price', 10, 2);
            $table->decimal('children_price', 10, 2);
            $table->decimal('commission_rate', 5, 2)->default(15.00);
            $table->date('season_start')->nullable();
            $table->date('season_end')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('property_pricing');
    }
};