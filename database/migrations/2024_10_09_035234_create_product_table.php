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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->text('thumbnail')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('sku')->nullable();
            $table->integer('qty')->default(0); 
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('price_sale', 10, 2)->nullable();
            $table->enum('product_type', ['Sale', 'Hot Trend']);
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints (if applicable)
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_');
    }
};
