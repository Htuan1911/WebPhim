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
            $table->dropColumn('cinema_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cinema_rooms', function (Blueprint $table) {
            $table->unsignedBigInteger('cinema_id')->nullable(false);
        });
    }
};
