<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('taxis', function (Blueprint $table) {
            $table->string('nearest_city')->nullable();
        });
    }

    public function down()
    {
        Schema::table('taxis', function (Blueprint $table) {
            $table->dropColumn('nearest_city');
        });
    }
};
