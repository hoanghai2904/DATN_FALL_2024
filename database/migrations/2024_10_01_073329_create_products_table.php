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
            $table->integer('category_id'); // ID danh mục
            $table->integer('brand_id'); // ID thương hiệu
            $table->text('thumbnail')->nullable(); // Đường dẫn đến hình ảnh thu nhỏ
            $table->string('name'); // Tên sản phẩm
            $table->string('slug'); // Chuỗi đại diện cho sản phẩm
            $table->string('sku'); // Mã sản phẩm
            $table->text('description')->nullable(); // Mô tả ngắn
            $table->text('content')->nullable(); // Nội dung chi tiết sản phẩm
            $table->decimal('price', 10, 2); // Giá sản phẩm
            $table->decimal('price_sale', 10, 2)->nullable(); // Giá khuyến mãi sản phẩm
            $table->enum('product_type', ['Sale', 'Hot Trend']); // Loại sản phẩm
            $table->tinyInteger('status')->default(1); // Trạng thái hoạt động (0: ẩn, 1: hiện)
            $table->timestamps(); // created_at và updated_at
            $table->softDeletes(); // deleted_at (xóa mềm)
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
