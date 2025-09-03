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
    Schema::table('cars', function (Blueprint $table) {
        $table->enum('pricing_type', ['perDay', 'perKm'])->nullable()->after('fuel_type');
        $table->decimal('price_per_km', 10, 2)->nullable()->after('price_per_day');
    });
}

public function down(): void
{
    Schema::table('cars', function (Blueprint $table) {
        $table->dropColumn(['pricing_type', 'price_per_km']);
    });
}
};
