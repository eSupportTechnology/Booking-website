<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('property_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties');
            $table->enum('cancellation_policy', ['flexible', 'moderate', 'strict']);
            $table->time('check_in_from');
            $table->time('check_in_until');
            $table->time('check_out_from');
            $table->time('check_out_until');
            $table->boolean('smoking_allowed')->default(false);
            $table->boolean('parties_allowed')->default(false);
            $table->string('pets_allowed')->nullable();
            $table->string('pets_fees')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_policies');
    }
};
