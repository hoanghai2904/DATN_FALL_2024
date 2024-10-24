<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Lặp qua mỗi đơn hàng và tạo sản phẩm cho từng đơn hàng
        foreach (\App\Models\Order::all() as $order) {
            OrderItem::factory()->count(3)->create(['order_id' => $order->id]); // Tạo 3 sản phẩm cho mỗi đơn hàng
        }
    }
}
