<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // Cột order_id
            $table->unsignedBigInteger('product_variant_id');
            $table->integer('qty');
            $table->string('product_name');
            $table->string('product_sku');
            $table->string('product_thumbnail');
            $table->decimal('product_price', 10, 2);
            $table->decimal('product_price_sale', 10, 2)->nullable();
            $table->string('variant_size_name')->nullable();
            $table->string('variant_color_name')->nullable();
            $table->timestamps();
    
            // Thiết lập khóa ngoại cho order_id
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }
    
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};