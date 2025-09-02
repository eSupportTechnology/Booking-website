<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('files', function (Blueprint $table) {
//            $table->dropForeign(['property_id']);

            $table->unsignedBigInteger('property_id')->nullable()->change();

            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropForeign(['property_id']);

            $table->unsignedBigInteger('property_id')->nullable(false)->change();

            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }
};
