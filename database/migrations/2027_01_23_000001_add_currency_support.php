<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add currency to bookings
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'currency')) {
                $table->string('currency', 3)->default('USD')->after('total_price');
            }
            if (!Schema::hasColumn('bookings', 'base_currency')) {
                $table->string('base_currency', 3)->nullable()->after('currency');
            }
        });

        // Add currency to cars
        Schema::table('cars', function (Blueprint $table) {
            if (!Schema::hasColumn('cars', 'currency')) {
                $table->string('currency', 3)->default('USD')->after('deposit');
            }
        });

        // Add currency to rooms
        Schema::table('rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('rooms', 'currency')) {
                $table->string('currency', 3)->default('USD')->after('price_per_night');
            }
        });

        // Create exchange_rates table
        if (!Schema::hasTable('exchange_rates')) {
            Schema::create('exchange_rates', function (Blueprint $table) {
                $table->id();
                $table->string('from_currency', 3);
                $table->string('to_currency', 3);
                $table->decimal('rate', 10, 6);
                $table->timestamp('cached_at');
                $table->timestamps();
                
                $table->unique(['from_currency', 'to_currency']);
            });
        }
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'currency')) {
                $table->dropColumn('currency');
            }
            if (Schema::hasColumn('bookings', 'base_currency')) {
                $table->dropColumn('base_currency');
            }
        });

        Schema::table('cars', function (Blueprint $table) {
            if (Schema::hasColumn('cars', 'currency')) {
                $table->dropColumn('currency');
            }
        });

        Schema::table('rooms', function (Blueprint $table) {
            if (Schema::hasColumn('rooms', 'currency')) {
                $table->dropColumn('currency');
            }
        });

        Schema::dropIfExists('exchange_rates');
    }
};