<?php

namespace Database\Factories;

use App\Models\admin\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,  // ID người dùng ngẫu nhiên
            'product_id' => Product::inRandomOrder()->first()->id,  // ID sản phẩm ngẫu nhiên
            'rating' => $this->faker->numberBetween(1, 5),  // Đánh giá từ 1 - 5 sao
            'comment' => $this->faker->sentence,  // Nội dung bình luận giả lập
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
