<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = \App\Models\OrderItem::class;

    public function definition()
    {
        return [
            'order_id' => Order::factory(), // Tạo đơn hàng mới hoặc chỉ định đơn hàng đã có
            'product_id' => Product::inRandomOrder()->first()->id, // Lấy ngẫu nhiên sản phẩm đã có
            'product_name' => $this->faker->word,
            'variant_size' => $this->faker->word,
            'variant_color' => $this->faker->word,
            'variant_weight' => $this->faker->randomFloat(2, 0, 10),
            'qty' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'total_price' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
