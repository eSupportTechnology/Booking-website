<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Deal;

return new class extends Migration
{
    public function up()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->string('currency', 3)->default('USD')->after('deal_type');
        });

        // Backfill currency from related property
        Deal::with('property')->chunk(100, function ($deals) {
            foreach ($deals as $deal) {
                if ($deal->property) {
                    $deal->update([
                        'currency' => $deal->property->currency ?? 'USD'
                    ]);
                }
            }
        });
    }

    public function down()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->dropColumn('currency');
        });
    }
};
