<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_additional_details', function (Blueprint $table) {
            $table->integer('bedrooms')->nullable()->after('guests');
        });
    }

    public function down(): void
    {
        Schema::table('property_additional_details', function (Blueprint $table) {
            $table->dropColumn('bedrooms');
        });
    }
};