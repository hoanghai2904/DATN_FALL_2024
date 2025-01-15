<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order; // Đảm bảo đúng namespace model Order
use Carbon\Carbon;

class AutoUpdateOrderStatus extends Command
{
    protected $signature = 'order:update';
    protected $description = 'Tự động cập nhật trạng thái đơn hàng thành đã nhận sau 3 ngày';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $threeDaysAgo = Carbon::now()->subDays(3);
        // $threeDaysAgo = Carbon::now()->subMinutes(1);

        // Lấy các đơn hàng có trạng thái = 4 và chưa được đánh dấu là đã nhận
        $orders = Order::where('status', 4)
            ->where('updated_at', '<=', $threeDaysAgo)
            ->get();

        foreach ($orders as $order) {
            $order->status = 6; // Trạng thái 'đã nhận'
            $order->save();
            $this->info("Đã cập nhật đơn hàng ID {$order->id} thành 'đã nhận'.");
        }

        $this->info('Hoàn thành cập nhật trạng thái đơn hàng.');
    }
}