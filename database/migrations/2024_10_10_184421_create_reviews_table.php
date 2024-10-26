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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID người dùng
            $table->foreignId('order_status_id')->constrained()->onDelete('cascade'); // ID trang thái đơn hàng
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // ID trang thái đơn hàng
            $table->string('rating'); // Điểm đánh giá
            $table->text('comment')->nullable(); // Nội dung đánh giá
            $table->timestamps();
            $table->softDeletes(); // Xóa mềm
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
