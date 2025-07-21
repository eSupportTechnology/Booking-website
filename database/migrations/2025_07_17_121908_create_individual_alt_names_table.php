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
        if (!Schema::hasTable('individual_alt_names')) {
            Schema::create('individual_alt_names', function (Blueprint $table) {
                $table->id();
                $table->foreignId('individual_id')->constrained('individuals')->onDelete('cascade');
                $table->string('alt_name');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individual_alt_names');
    }
};
