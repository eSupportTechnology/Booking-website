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
        if (!Schema::hasTable('business_entities')) {
            Schema::create('business_entities', function (Blueprint $table) {
                $table->id();
                $table->foreignId('accommodation_id')->constrained('accommodations')->onDelete('cascade');
                $table->string('business_name');
                $table->string('trading_name')->nullable();
                $table->text('address');
                $table->string('zip_code');
                $table->string('city');
                $table->string('country');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_entities');
    }
};
