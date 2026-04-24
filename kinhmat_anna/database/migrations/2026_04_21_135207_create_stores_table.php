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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên cửa hàng
            $table->string('address'); // Địa chỉ chi tiết
            $table->string('phone'); // Số điện thoại
            $table->string('open_time'); // Giờ mở cửa
            $table->string('city')->nullable(); // Thành phố (Để làm bộ lọc AJAX sau này)
            $table->text('map_url'); // Chứa link Embed của Google Maps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
