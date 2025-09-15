<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->string('full_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('timezone')->default('UTC');
            $table->string('language')->default('en');
            $table->json('notification_preferences')->nullable();
            $table->boolean('two_factor_enabled')->default(false);
            $table->timestamp('last_password_change')->nullable();
            $table->timestamps();
            
            $table->unique('admin_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_settings');
    }
};