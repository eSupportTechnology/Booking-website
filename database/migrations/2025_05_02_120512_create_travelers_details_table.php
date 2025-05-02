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
        Schema::create('travelers_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('traveler_id')->constrained('travelers')->onDelete('cascade');
            $table->string('display_name')->nullable();
            $table->string('phone')->nullable();
            $table->date('dob')->nullable();
            $table->string('nationality')->nullable();
            $table->string('gender')->nullable();
            $table->string('passport_details')->nullable();
            $table->text('address')->nullable();
            $table->string('profile_picture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travelers_details');
    }
};
