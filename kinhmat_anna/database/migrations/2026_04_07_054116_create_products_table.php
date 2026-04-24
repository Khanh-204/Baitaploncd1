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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('price');
            $table->string('image')->nullable();
            $table->integer('stock')->default(0);
            
            // --- 4 CỘT MỚI THÊM CHUẨN E-COMMERCE ---
            $table->integer('sale_price')->nullable(); // Giá khuyến mãi (có thể trống)
            $table->boolean('is_featured')->default(false); // Nổi bật (HOT)
            $table->integer('sold')->default(0); // Số lượng đã bán
            $table->decimal('rating', 2, 1)->default(5.0); // Đánh giá sao (VD: 4.8)
            // ---------------------------------------

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
