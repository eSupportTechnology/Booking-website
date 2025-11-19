<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('property_pricings', function (Blueprint $table) {
            if (!Schema::hasColumn('property_pricings', 'adult_price')) {
                $table->decimal('adult_price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('property_pricings', 'child_price')) {
                $table->decimal('child_price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('property_pricings', 'commission_rate')) {
                $table->decimal('commission_rate', 5, 2)->default(0);
            }
            if (!Schema::hasColumn('property_pricings', 'total_price_with_commission')) {
                $table->decimal('total_price_with_commission', 10, 2)->nullable();
            }
        });

        // Also add to properties table for backward compatibility
        Schema::table('properties', function (Blueprint $table) {
            if (!Schema::hasColumn('properties', 'adult_price')) {
                $table->decimal('adult_price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('properties', 'child_price')) {
                $table->decimal('child_price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('properties', 'commission_rate')) {
                $table->decimal('commission_rate', 5, 2)->default(10);
            }
            if (!Schema::hasColumn('properties', 'total_price_with_commission')) {
                $table->decimal('total_price_with_commission', 10, 2)->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('property_pricings', function (Blueprint $table) {
            $table->dropColumn(['adult_price', 'child_price', 'commission_rate', 'total_price_with_commission']);
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['adult_price', 'child_price', 'commission_rate', 'total_price_with_commission']);
        });
    }
};