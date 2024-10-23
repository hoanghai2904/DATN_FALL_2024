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
        Schema::create('product_variant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->nullable(); // Liên kết với bảng products
            $table->foreignId('variant_type_id')->constrained('variant_types')->onDelete('cascade')->nullable(); // Liên kết với bảng variant_types
            $table->foreignId('variant_value_id')->constrained('variant_values')->onDelete('cascade')->nullable(); // Liên kết với bảng variant_values
            $table->integer('qty'); // Số lượng sản phẩm cho mỗi biến thể
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable(); // Hình ảnh tùy chọn cho biến thể
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant_');
    }
};
