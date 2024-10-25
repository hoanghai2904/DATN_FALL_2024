<?php

namespace Database\Seeders;

use App\Models\OrderStatusLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        OrderStatusLog::factory()->count(10)->create(); // Tạo 10 bản ghi OrderStatusLog
    }
}
