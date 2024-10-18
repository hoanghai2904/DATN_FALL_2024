<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
            ->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])
            ->count();

        $customersThisWeek = User::doesntHave('roles')
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->count();

        // Tính phần trăm thay đổi khách hàng
        $customerChange = $customersLastWeek > 0 
            ? (($customersThisWeek - $customersLastWeek) / $customersLastWeek) * 100 
            : 0;

        // // Tổng thu nhập và thu nhập từng tuần
        // $totalEarnings = Order::where('status', 'paid')->sum('total_amount');

        // $earningsLastWeek = Order::where('status', 'paid')
        //     ->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])
        //     ->sum('total_amount');

        // $earningsThisWeek = Order::where('status', 'paid')
        //     ->whereBetween('created_at', [now()->subDays(7), now()])
        //     ->sum('total_amount');

        // // Tính phần trăm thay đổi thu nhập
        // $earningsChange = $earningsLastWeek > 0 
        //     ? (($earningsThisWeek - $earningsLastWeek) / $earningsLastWeek) * 100 
        //     : 0;

        // // Thống kê đơn hàng
        // $totalOrders = Order::count();

        // $ordersLastWeek = Order::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();
        // $ordersThisWeek = Order::whereBetween('created_at', [now()->subDays(7), now()])->count();

        // $orderChange = $ordersLastWeek > 0 
        //     ? (($ordersThisWeek - $ordersLastWeek) / $ordersLastWeek) * 100 
        //     : 0;

        // Truyền dữ liệu qua view
        return view('admin.dashboard', compact(
            'totalCustomers', 
            'customerChange', 
            // 'totalEarnings', 
            // 'earningsChange',
            // 'totalOrders', 
            // 'orderChange'
        ));
    }
}
