<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('house_rules', function (Blueprint $table) {
$table->id();
        $table->foreignId('property_id')->constrained('properties');
        $table->text('rule');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('house_rules');
    }
};
