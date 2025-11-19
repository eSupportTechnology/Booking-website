<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seasonal_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('season_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('adult_price', 10, 2);
            $table->decimal('child_price', 10, 2)->nullable();
            $table->decimal('commission_rate', 5, 2)->default(10);
            $table->decimal('total_price_with_commission', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['property_id', 'start_date', 'end_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('seasonal_pricings');
    }
};