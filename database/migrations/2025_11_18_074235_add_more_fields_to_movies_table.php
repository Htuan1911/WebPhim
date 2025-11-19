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
        Schema::table('movies', function (Blueprint $table) {
            $table->string('age_rating')->nullable()->after('genre');   // độ tuổi
            $table->string('banner')->nullable()->after('poster');      // banner phim
            $table->string('trailer')->nullable()->after('trailer_url'); // trailer mới
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn(['age_rating', 'banner', 'trailer']);
        });
    }
};
