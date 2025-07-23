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
        Schema::table('property_policies', function (Blueprint $table) {
            $table->time('check_in_until');
            $table->time('check_out_until');
            $table->boolean('children_allowed')->default(false);
            $table->boolean('party_allowed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_policies', function (Blueprint $table) {
            $table->dropColumn(['check_in_until', 'check_out_until', 'children_allowed', 'party_allowed']);
        });
    }
};
