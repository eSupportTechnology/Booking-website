<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
 {
    public function up(): void {
        Schema::create('car_renters', function (Blueprint $table) {
            $table->id();
            
            // Common fields
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('account_type', ['company', 'individual']); // type selector
            
            // Company fields (nullable for individual accounts)
            $table->string('company_name')->nullable();
            $table->string('business_reg_no')->nullable();
            $table->string('company_logo')->nullable();
            
            // Individual fields (nullable for company accounts)
            $table->string('full_name')->nullable();
            $table->string('nic_number')->nullable();
            
            // Shared fields
            $table->string('phone')->nullable();
            $table->string('country_code', 10)->nullable();
            $table->text('address')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('car_renters');
    }
};