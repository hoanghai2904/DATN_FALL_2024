<?php

namespace Database\Factories;


use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition()
    {
        return [
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id, // Lấy ngẫu nhiên một category
            'brand_id' => \App\Models\Brands::inRandomOrder()->first()->id,       // Lấy ngẫu nhiên một brand
            'thumbnail' => $this->faker->imageUrl(),
            'name' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'sku' => $this->faker->unique()->word(),
            'qty' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->paragraph(),
            'content' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'price_sale' => $this->faker->randomFloat(2, 5, 500),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
    
}
