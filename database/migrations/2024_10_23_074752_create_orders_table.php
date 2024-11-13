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
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('order_code')->unique();
        $table->decimal('total_amount', 10, 2);
        $table->decimal('discount', 10, 2)->default(0);
        $table->decimal('shipping_fee', 10, 2)->default(0);
        $table->enum('payment_status', ['Chưa thanh toán', 'Đã thánh toán'])->default('Chưa thanh toán');
        $table->enum('order_status', ['Đang xử lí', 'Đang giao ', 'Đã giao', 'Đã hủy'])->default('Đang xử lí');
        $table->string('payment_method');
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
