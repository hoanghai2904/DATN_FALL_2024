<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserAddress;


class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        UserAddress::create([
            'user_id' => 1, // ID người dùng, hãy chắc chắn rằng người dùng này tồn tại
            'full_name' => 'Nguyễn Văn A',
            'cover' => 'link/to/image.jpg',
            'phone' => '0123456789',
            'address' => '123 Main St, Hà Nội',
            'email' => 'example@example.com',
            'province_id' => 1, // Giả sử ID tỉnh là 1
            'district_id' => '001', // ID quận
            'ward_id' => '001', // ID phường
            'is_default' => 1 // Địa chỉ mặc định
        ]);
    }
}
