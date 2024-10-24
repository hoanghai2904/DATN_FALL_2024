<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'order_id' => \App\Models\Order::factory(), // Tạo đơn hàng mới
            'payment_method' => $this->faker->randomElement(['Credit Card', 'PayPal', 'Bank Transfer']),
            'transaction_id' => 'TX-' . uniqid(),
            'payment_status' => $this->faker->randomElement(['Chưa thanh toán', 'Đã thanh toán']),
            'paid_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
