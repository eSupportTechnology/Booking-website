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
        $table->time('check_in_time');
        $table->time('check_out_time');
        $table->boolean('smoking_allowed')->default(false);
        $table->boolean('pets_allowed')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_policies');
    }
};
