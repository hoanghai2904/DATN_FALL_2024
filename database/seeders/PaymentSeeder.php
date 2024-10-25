<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (\App\Models\Order::all() as $order) {
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'Credit Card',
                'transaction_id' => 'TX-' . uniqid(),
                'payment_status' => 'Đã thanh toán',
                'paid_at' => now(),
            ]);
        }
    }
}
