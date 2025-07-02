<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('room_availability', function (Blueprint $table) {
$table->id();
        $table->foreignId('room_id')->constrained('rooms');
        $table->date('date');
        $table->boolean('is_available')->default(true);
        $table->decimal('price_override', 10, 2)->nullable();
        $table->integer('min_stay')->nullable();
        $table->integer('max_stay')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_availability');
    }
};
