<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderCodeToOrdersTable extends Migration
{
    public function up()
    {
        // Kiểm tra xem cột 'order_code' đã tồn tại chưa
        if (!Schema::hasColumn('orders', 'order_code')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('order_code')->notNull();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa cột 'order_code' nếu tồn tại
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'order_code')) {
                $table->dropColumn('order_code');
            }
        });
    }
}
