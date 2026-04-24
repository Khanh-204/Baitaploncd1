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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // Thêm cột này để quản lý mã đơn (ANNA123...)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng users
            $table->string('phone'); // Khớp với OrderSeeder
            $table->string('address'); // Khớp với OrderSeeder
            $table->text('notes')->nullable();
            $table->integer('total_amount');
            $table->string('status')->default('pending'); // pending, processing, shipped, completed, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
