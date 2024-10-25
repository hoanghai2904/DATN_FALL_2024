<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Lấy người dùng không có vai trò
        $totalCustomers = User::doesntHave('roles')->count();

        // Lấy khách hàng tuần trước và tuần này
        $customersLastWeek = User::doesntHave('roles')
            ->whereBetween('created_at', [now()->subDays(30), now()->subDays(7)])
            ->count();

        $customersThisWeek = User::doesntHave('roles')
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->count();

        // Tính phần trăm thay đổi khách hàng
        $customerChange = $customersLastWeek > 0
            ? (($customersThisWeek - $customersLastWeek) / $customersLastWeek) * 100
            : 0;

        // Tổng thu nhập và thu nhập từng tuần
        $totalEarnings = Order::where('order_status', 'Đã giao')->sum('total_amount');

        $earningsLastWeek = Order::where('order_status', 'Đã giao')
            ->whereBetween('created_at', [now()->subDays(30), now()->subDays(7)])
            ->sum('total_amount');

        $earningsThisWeek = Order::where('order_status', 'Đã giao')
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->sum('total_amount');

        // Tính phần trăm thay đổi thu nhập
        $earningsChange = $earningsLastWeek > 0
            ? (($earningsThisWeek - $earningsLastWeek) / $earningsLastWeek) * 100
            : 0;

        // Thống kê đơn hàng
        $totalOrders = Order::count();
        $totalOrdersDone = Order::where('order_status', 'Đã giao')->count();
        $ordersLastWeek = Order::whereBetween('created_at', [now()->subDays(30), now()->subDays(7)])->count();
        $ordersThisWeek = Order::whereBetween('created_at', [now()->subDays(7), now()])->count();

        $orderChange = $ordersLastWeek > 0
            ? (($ordersThisWeek - $ordersLastWeek) / $ordersLastWeek) * 100
            : 0;
        //
        $ordersData  = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $incomeData  = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $canceledData  = Order::where('order_status', 'Đã hủy')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();
        $orders = array_replace(array_fill(1, 12, 0), $ordersData);
        $income = array_replace(array_fill(1, 12, 0), $incomeData);
        $canceled = array_replace(array_fill(1, 12, 0), $canceledData);

        // Lấy các sản phẩm bán chạy nhất dựa trên tổng số lượng đã bán
        $bestSellingProducts = Product::withCount(['OrderItem as total_quantity' => function ($query) {
            $query->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.order_status', 'Đã giao'); // Chỉ lấy đơn hàng đã hoàn thành
        }])
            ->orderBy('total_quantity', 'desc')
            ->paginate(4); // Số lượng sản phẩm hiển thị mỗi trang

         // Lấy danh sách các đơn hàng cùng với thông tin khách hàng
         $ordersview = Order::with('user') // 'user' là quan hệ giữa Order và User
         ->paginate(6); // Số lượng đơn hàng hiển thị mỗi trang
 
        // Truyền dữ liệu qua view
        return view('admin.dashboard', compact(
            'totalCustomers',
            'customerChange',
            'totalEarnings',
            'earningsChange',
            'totalOrders',
            'orderChange',
            'totalOrdersDone',
            'orders',
            'income',
            'canceled',
            'bestSellingProducts',
            'ordersview'

        ));
    }

    public function orders()
    {
       
        return view('your_view_name', compact('orders'));
    }
    
}
