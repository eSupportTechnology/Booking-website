<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_personal_details', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['address', 'passport_details']);

            // Add new columns after 'gender'
            $table->string('country')->nullable()->after('gender');
            $table->string('street')->nullable()->after('country');
            $table->string('city')->nullable()->after('street');
            $table->string('postcode')->nullable()->after('city');

            $table->string('passport_name')->nullable()->after('postcode');
            $table->string('issuingCountry')->nullable()->after('passport_name');
            $table->string('passportNumber')->nullable()->after('issuingCountry');
            $table->date('passport_expiry_date')->nullable()->after('passportNumber');
        });
    }

    public function down(): void
    {
        Schema::table('customer_personal_details', function (Blueprint $table) {
            // Re-add dropped columns
            $table->text('address')->nullable();
            $table->text('passport_details')->nullable();

            // Drop the newly added columns
            $table->dropColumn([
                'country',
                'street',
                'city',
                'postcode',
                'passport_name',
                'issuingCountry',
                'passportNumber',
                'passport_expiry_date',
            ]);
        });
    }
};
