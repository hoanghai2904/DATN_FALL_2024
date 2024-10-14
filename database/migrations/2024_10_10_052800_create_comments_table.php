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
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Khóa chính
            $table->unsignedBigInteger('user_id'); // ID người dùng
            $table->unsignedBigInteger('product_id'); // ID sản phẩm được đánh giá
            $table->text('rating'); // Đánh giá từ 1-5 sao
            $table->text('comment'); // Nội dung bình luận
            $table->boolean('status')->default(1); // Using boolean with default value
            $table->timestamps(); // Thời điểm tạo và cập nhật lần cuối
            $table->softDeletes(); // Thời điểm xóa (xóa mềm)
    
            // Khóa ngoại (nếu cần thiết)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
