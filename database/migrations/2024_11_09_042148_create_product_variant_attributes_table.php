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
        Schema::create('product_variant_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('variant_id');
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('value_id');
            $table->timestamps();

            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('product_attributes')->onDelete('cascade');
            $table->foreign('value_id')->references('id')->on('product_attribute_values')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_variant_attributes');
    }
};
