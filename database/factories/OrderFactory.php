<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Order::class;
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(), // Tạo user mới hoặc chỉ định user đã có
            'order_code' => $this->faker->unique()->word,
            'total_amount' => $this->faker->randomFloat(2, 50, 500),
            'discount' => $this->faker->randomFloat(2, 0, 20),
            'shipping_fee' => $this->faker->randomFloat(2, 5, 15),
            'payment_status' => $this->faker->randomElement(['Chưa thanh toán', 'Đã thanh toán']),
            'order_status' => $this->faker->randomElement(['Đang xử lí', 'Đang giao', 'Đã giao', 'Đã hủy']),
            'payment_method' => 'Thẻ tín dụng',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
