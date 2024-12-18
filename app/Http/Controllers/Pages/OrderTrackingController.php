<?php

namespace App\Http\Controllers\pages;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Advertise;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index()
    {
        // Có thể lấy các quảng cáo, nếu có trong hệ thống
        $advertises = Advertise::where([
            ['start_date', '<=', date('Y-m-d')],
            ['end_date', '>=', date('Y-m-d')],
            ['at_home_page', '=', false],
          ])->latest()->limit(5)->get(['product_id', 'title', 'image']);

        return view('pages.tracking', compact('advertises'));
    }

    /**
     * Tìm kiếm thông tin đơn hàng theo mã đơn.
     */
    public function searchOrder(Request $request)
    {
        $orderId = $request->input('order_code');
    
        // Kiểm tra đơn hàng có tồn tại không
        $order = Order::where('order_code', $orderId)->first();
    
        if (!$order) {
            return response()->json(['message' => 'Không tìm thấy đơn hàng'], 404);
        }
    
        // Các bước trong quy trình đơn hàng
        $stepsArray = [
            OrderStatusEnum::PENDING => ['icon' => 'fas fa-spinner', 'text' => OrderStatusEnum::PENDING],
            OrderStatusEnum::CONFIRMED => ['icon' => 'fas fa-check-circle', 'text' => OrderStatusEnum::CONFIRMED],
            OrderStatusEnum::DELIVERING => ['icon' => 'fas fa-truck', 'text' => OrderStatusEnum::DELIVERING],
            OrderStatusEnum::DELIVERED => ['icon' => 'fas fa-box', 'text' => OrderStatusEnum::DELIVERED],
            OrderStatusEnum::COMPLETED => ['icon' => 'fas fa-flag-checkered', 'text' => OrderStatusEnum::COMPLETED],
        ];
    
        // Trả về dữ liệu trạng thái đơn hàng
        return response()->json([
            'order_status' => $order->status,
            'order_status_label' => $stepsArray[$order->status] ?? 'Không xác định',
            'order_steps' => $this->getOrderSteps($order->status),
            'steps_array' => $stepsArray, // Gửi mảng trạng thái
            'order_code' => $order->order_code
        ]);
    }
    

    /**
     * Lấy các bước của đơn hàng theo trạng thái.
     */
    private function getOrderSteps($status)
    {
        $stepsArray = [
            OrderStatusEnum::PENDING => ['icon' => 'fas fa-spinner', 'text' => OrderStatusEnum::PENDING],
            OrderStatusEnum::CONFIRMED => ['icon' => 'fas fa-check-circle', 'text' => OrderStatusEnum::CONFIRMED],
            OrderStatusEnum::DELIVERING => ['icon' => 'fas fa-truck', 'text' => OrderStatusEnum::DELIVERING],
            OrderStatusEnum::DELIVERED => ['icon' => 'fas fa-box', 'text' => OrderStatusEnum::DELIVERED],
            OrderStatusEnum::COMPLETED => ['icon' => 'fas fa-flag-checkered', 'text' => OrderStatusEnum::COMPLETED],
        ];

        return $stepsArray[$status] ?? [];
    }
}
