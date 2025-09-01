<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Add room_type_id
            $table->foreignId('room_type_id')
                ->after('property_id')
                ->constrained('room_types')
                ->onDelete('cascade');

            // Remove bed_count column
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Reverse changes
            $table->dropForeign(['room_type_id']);
            $table->dropColumn('room_type_id');
            $table->dropColumn('bed_count');

        });
    }
};
