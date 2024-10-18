<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Khóa ngoại đến bảng categories
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade'); // Khóa ngoại đến bảng brands
            $table->text('thumbnail')->nullable(); 
            $table->string('name'); 
            $table->string('slug'); 
            $table->string('sku'); 
            $table->integer('qty')->default(0); 
            $table->text('description')->nullable(); 
            $table->text('content')->nullable(); 
            $table->decimal('price', 10, 2); 
            $table->decimal('price_sale', 10, 2)->nullable(); 
            $table->tinyInteger('status')->default(1); 
            $table->timestamps(); 
            $table->softDeletes(); 
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
