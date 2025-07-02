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
        Schema::table('properties', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->string('zipcode')->nullable()->change();
            $table->unsignedBigInteger('address_type_id')->nullable()->change();
            // Add more fields here if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('country')->nullable(false)->change();
            $table->string('zipcode')->nullable(false)->change();
            $table->unsignedBigInteger('address_type_id')->nullable(false)->change();
            // Reverse for more fields if needed
        });
    }
};
