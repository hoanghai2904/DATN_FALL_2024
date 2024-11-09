<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_galleries', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // ID sản phẩm
            $table->text('image')->nullable(); // Đường dẫn đến hình ảnh
            $table->text('name')->nullable(); // Tên sản phẩm
            $table->timestamps(); // Thời điểm được tạo và cập nhật lần cuối
            $table->softDeletes(); // Xóa mềm

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_galleries');
    }
};
