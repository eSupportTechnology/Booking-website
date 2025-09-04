<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('taxi_id')->constrained('taxis')->cascadeOnDelete();
            $table->string('name');
            $table->string('contact_number');
            $table->string('email')->nullable();
            $table->string('license_number')->unique();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
