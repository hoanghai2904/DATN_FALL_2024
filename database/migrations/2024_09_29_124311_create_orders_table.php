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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->string('user_name');
            $table->string('user_email');
            $table->string('user_phone');
            $table->text('user_address');
            $table->text('user_note')->nullable();
<<<<<<< HEAD
            $table->string('status_order')->default('Chưa giải quyết'); 
            $table->decimal('shipping_fee', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->enum('payment_method', ['Thanh toán khi nhận hàng', 'Chuyển Khoản']);
=======
            $table->string('status_order')->default('pending'); // Trạng thái (Pending, Shipped, Delivered, Cancelled)
            $table->decimal('shipping_fee', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->enum('payment_method', ['COD', 'Banking']);
>>>>>>> 45fccf81dd0db1a6d9fc4581b1660a197a6fec42
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
