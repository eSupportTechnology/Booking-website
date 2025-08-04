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
        if (!Schema::hasTable('individuals')) {
            Schema::create('individuals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('accommodation_id')->constrained('accommodations')->onDelete('cascade');
                $table->string('first_name');
                $table->string('last_name');
                $table->date('date_of_birth')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individuals');
    }
};
