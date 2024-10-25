<?php

namespace Database\Seeders;

use App\Models\Shipment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (\App\Models\Order::all() as $order) {
            Shipment::create([
                'order_id' => $order->id,
                'carrier_name' => 'Carrier Name',
                'tracking_number' => 'TRACK-' . uniqid(),
                'shipping_status' => 'Đang giao',
                'shipped_at' => now(),
                'delivered_at' => null,
            ]);
        }
    }
}
