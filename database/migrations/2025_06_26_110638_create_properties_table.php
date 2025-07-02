<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
$table->id();
        $table->foreignId('user_id')->constrained('users');
        $table->foreignId('category_id')->constrained('property_categories');
        $table->foreignId('subcategory_id')->constrained('property_subcategories');
        $table->foreignId('subtype_id')->constrained('property_subtypes');
        $table->foreignId('address_type_id')->constrained('address_types');
        $table->string('title');
        $table->text('description');
        $table->text('address');
        $table->string('city');
        $table->string('country');
        $table->decimal('latitude', 10, 6)->nullable();
        $table->decimal('longitude', 10, 6)->nullable();
        $table->enum('status', ['pending', 'active', 'suspended'])->default('pending');
        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
