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
        Schema::create('room_template_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_template_id')->constrained()->onDelete('cascade');
            $table->string('seat_number'); // Ví dụ: A1, B10,...
            $table->string('type')->default('normal'); // normal / vip / couple ...
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_template_seats');
    }
};
