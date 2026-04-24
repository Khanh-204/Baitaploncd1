<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kiểm tra: Nếu chưa có cột likes_count thì ép tạo
        if (!Schema::hasColumn('products', 'likes_count')) {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedInteger('likes_count')->default(0)->after('price');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'likes_count')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('likes_count');
            });
        }
    }
};