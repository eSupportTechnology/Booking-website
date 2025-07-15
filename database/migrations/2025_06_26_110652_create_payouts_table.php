<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payouts', function (Blueprint $table) {
$table->id();
        $table->foreignId('host_id')->constrained('users');
        $table->foreignId('booking_id')->constrained('bookings');
        $table->decimal('amount', 10, 2);
        $table->enum('payout_status', ['pending', 'processing', 'completed', 'failed']);
        $table->enum('payout_method', ['paypal', 'bank', 'stripe']);
        $table->string('transaction_reference')->nullable();
        $table->timestamp('payout_date')->nullable();
        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payouts');
    }
};
