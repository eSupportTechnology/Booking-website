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
        Schema::create('property_host_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->text('about_property')->nullable();
            $table->text('about_host')->nullable();
            $table->text('about_neighborhood')->nullable();
            $table->boolean('show_property')->default(false);
            $table->boolean('show_host')->default(false);
            $table->boolean('show_neighborhood')->default(false);
            $table->boolean('none_selected')->default(false);
            $table->string('host_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_host_profiles');
    }
};
