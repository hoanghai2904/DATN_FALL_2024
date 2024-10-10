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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_type_id')->constrained('product_types')->onDelete('cascade')->nullable();
            $table->foreignId('product_weight_id')->constrained('product_weights')->onDelete('cascade')->nullable();
            $table->integer('qty');
            $table->decimal('price_variant', 10, 2);
            $table->text('image')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Xóa mềm
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
