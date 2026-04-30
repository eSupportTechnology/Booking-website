<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deal_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained()->onDelete('cascade');
            $table->date('available_date');
            $table->boolean('is_weekend')->default(false);
            $table->timestamps();
            
            $table->unique(['deal_id', 'available_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('deal_dates');
    }
};