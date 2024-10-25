<?php

namespace Database\Factories;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Shipment::class;

    public function definition()
    {
        return [
            'order_id' => \App\Models\Order::factory(), // Tạo đơn hàng mới
            'carrier_name' => $this->faker->company,
            'tracking_number' => 'TRACK-' . uniqid(),
            'shipping_status' => $this->faker->randomElement(['Đang xử lí', 'Đang giao', 'Hoàn thành', 'Đã hủy']),
            'shipped_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'delivered_at' => $this->faker->dateTimeBetween('now', '+1 week'),
        ];
    }
}
