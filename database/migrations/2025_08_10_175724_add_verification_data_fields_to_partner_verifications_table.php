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
        Schema::table('partner_verifications', function (Blueprint $table) {
            if (!Schema::hasColumn('partner_verifications', 'owners_data')) {
                $table->json('owners_data')->nullable()->after('type');
            }
            if (!Schema::hasColumn('partner_verifications', 'legal_company_name')) {
                $table->string('legal_company_name')->nullable()->after('owners_data');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partner_verifications', function (Blueprint $table) {
            $table->dropColumn(['owners_data', 'legal_company_name']);
        });
    }
};
