<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, we need to modify the enum to include 'completed'
        // MySQL doesn't support directly adding values to ENUM, so we need to recreate the column
        DB::statement("ALTER TABLE properties MODIFY COLUMN status ENUM('pending', 'active', 'suspended', 'completed') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'completed' from the enum
        DB::statement("ALTER TABLE properties MODIFY COLUMN status ENUM('pending', 'active', 'suspended') DEFAULT 'pending'");
    }
};
