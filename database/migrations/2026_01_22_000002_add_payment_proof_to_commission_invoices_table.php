<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commission_invoices', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('paid_at');
            $table->enum('payment_status', ['pending', 'submitted', 'approved', 'rejected'])->default('pending')->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('commission_invoices', function (Blueprint $table) {
            $table->dropColumn(['payment_proof', 'payment_status']);
        });
    }
};