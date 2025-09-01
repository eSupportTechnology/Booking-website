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
        Schema::table('rooms', function (Blueprint $table) {
            $table->enum('bathroom_type', ['private', 'shared'])->nullable()->after('bathroom_count');
            $table->json('bathroom_amenities')->nullable()->after('bathroom_type');
                  
            $table->integer('bed_count')->default(1)->after('bathroom_amenities');
            $table->string('currency', 5)->nullable()->default('usd')->after('bed_count');
            $table->boolean('discount_enabled')->default(false)->after('currency');
            $table->decimal('commission_percentage', 5, 2)->default(15)->after('discount_enabled');
            $table->decimal('you_earn', 10, 2)->nullable()->after('commission_percentage');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            //
        });
    }
};
