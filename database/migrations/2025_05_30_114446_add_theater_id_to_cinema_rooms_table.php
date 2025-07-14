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
        Schema::table('cinema_rooms', function (Blueprint $table) {
            $table->unsignedBigInteger('theater_id')->nullable()->after('id');

            $table->foreign('theater_id')->references('id')->on('theaters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cinema_rooms', function (Blueprint $table) {
            $table->dropForeign(['theater_id']);
            $table->dropColumn('theater_id');
        });
    }
};
