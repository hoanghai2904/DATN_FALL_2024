<?php

namespace Database\Factories;

use App\Models\OrderStatusLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderStatusLog>
 */
class OrderStatusLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = OrderStatusLog::class;

    public function definition()
    {
        return [
            'order_id' => \App\Models\Order::factory(), // Tạo đơn hàng mới
            'status' => $this->faker->randomElement(['Đang xử lí', 'Đang giao', 'Hoàn thành', 'Đã hủy']),
            'changed_by' => 1, // ID của người thay đổi trạng thái, có thể thay đổi tùy theo người dùng
            'created_at' => now(), // Thêm timestamp cho created_at
            'updated_at' => now(), // Thêm timestamp cho updated_at
        ];
    }
}
