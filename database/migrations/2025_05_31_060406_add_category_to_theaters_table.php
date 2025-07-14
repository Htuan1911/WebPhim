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
        Schema::table('theaters', function (Blueprint $table) {
            $table->string('category')->nullable()->after('name'); 
            // nullable cho phép chưa có danh mục vẫn được
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('theaters', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
