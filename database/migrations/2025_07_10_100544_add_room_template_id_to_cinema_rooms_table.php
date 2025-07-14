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
            $table->foreignId('room_template_id')->nullable()->after('cinema_id')->constrained('room_templates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cinema_rooms', function (Blueprint $table) {
            $table->dropForeign(['room_template_id']);
            $table->dropColumn(['cinema_id', 'room_template_id']);
        });
    }
};
