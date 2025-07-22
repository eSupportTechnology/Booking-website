<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::rename('property_photos', 'files');

        Schema::table('files', function (Blueprint $table) {
            $table->renameColumn('photo_url', 'path');

            $table->dropColumn('is_cover');

            $table->string('file_type')->nullable();
            $table->string('property_type')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn(['file_type', 'property_type']);
            $table->boolean('is_cover')->default(false);
            $table->renameColumn('path', 'photo_url');
        });

        Schema::rename('files', 'property_photos');
    }
};
