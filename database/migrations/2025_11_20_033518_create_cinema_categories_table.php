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
        // 1. Tạo bảng danh mục rạp mới (có ảnh)
        Schema::create('cinema_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable();        // Logo hãng rạp
            $table->text('description')->nullable();
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('theaters', function (Blueprint $table) {
            $table->foreignId('cinema_category_id')
                ->nullable()
                ->after('category')
                ->constrained('cinema_categories')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('theaters', function (Blueprint $table) {
            $table->dropForeign(['cinema_category_id']);
            $table->dropColumn('cinema_category_id');
        });
        Schema::dropIfExists('cinema_categories');
    }
};
