<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(), // Liên kết với user
            'full_name' => $this->faker->name, // Tên giả
            'cover' => $this->faker->imageUrl(), // Đường dẫn ảnh giả
            'phone' => $this->faker->numerify('##########'), // Số điện thoại giả
            'address' => $this->faker->address, // Địa chỉ giả
            'email' => $this->faker->unique()->safeEmail, // Email giả
            'province_id' => $this->faker->numberBetween(1, 100), // ID tỉnh/thành phố giả
            'district_id' => $this->faker->numberBetween(1, 100), // ID quận/huyện giả
            'ward_id' => $this->faker->numberBetween(1, 100), // ID phường/xã giả
            'is_default' => $this->faker->boolean, // Địa chỉ mặc định (0: Không, 1: Có)
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null, // Xóa mềm
        ];
    }
}
