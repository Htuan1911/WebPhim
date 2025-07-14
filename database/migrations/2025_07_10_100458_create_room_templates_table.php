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
        Schema::create('room_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ví dụ: "Phòng tiêu chuẩn 1"
            $table->integer('rows'); // Số hàng ghế
            $table->integer('columns'); // Số ghế mỗi hàng
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_templates');
    }
};
