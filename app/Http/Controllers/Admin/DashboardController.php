<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
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

            $incomeData = Order::where('order_status', 'Đã giao')
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
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
        
        // $perPage = 5; // Số sản phẩm hiển thị mỗi trang
        // $bestSellingProducts = Product::with(['orderItems' => function($query) {
        //     $query->whereHas('order', function($orderQuery) {
        //         $orderQuery->where('order_status', 'Đã giao'); // Chỉ lấy đơn hàng đã giao
        //     });
        // }])
        // ->where('status', 1) // Lọc sản phẩm đang hoạt động
        // ->selectRaw('products.*, SUM(order_items.qty) as total_sold') // Tính tổng số lượng đã bán
        // ->join('order_items', 'products.id', '=', 'order_items.product_id') // Kết nối với bảng order_items
        // ->join('orders', 'order_items.order_id', '=', 'orders.id') // Kết nối với bảng orders
        // ->where('orders.order_status', 'Đã giao') // Chỉ lấy các đơn hàng đã giao
        // ->groupBy(
        //     'products.id',
        //     'products.category_id',
        //     'products.brand_id',
        //     'products.thumbnail',
        //     'products.name',
        //     'products.slug',
        //     'products.sku',
        //     'products.qty',
        //     'products.description',
        //     'products.content',
        //     'products.price',
        //     'products.price_sale',
        //     'products.status',
        //     'products.created_at',
        //     'products.updated_at',
        //     'products.deleted_at'
        // )
        // ->distinct() // Thêm dòng này để loại bỏ các bản ghi trùng lặp
        // ->orderBy('total_sold', 'desc') // Sắp xếp theo số lượng đã bán
        // ->paginate($perPage); // Phân trang kết quả
    
           
        // Lấy danh sách các đơn hàng cùng với thông tin khách hàng, sắp xếp giảm dần
        $ordersview = Order::with('user') // 'user' là quan hệ giữa Order và User
            ->orderBy('created_at', 'desc') // Sắp xếp giảm dần theo ngày tạo
            ->paginate(6); // Số lượng đơn hàng hiển thị mỗi trang

        //hủy đơn 
        $canceledOrderCount = Order::where('order_status', 'Đã hủy')->count();
        $cancelPercentage = $totalOrders > 0 
    ? ($canceledOrderCount / $totalOrders) * 100 
    : 0;
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
            // 'bestSellingProducts',
            'ordersview',
            'canceledOrderCount',
            'cancelPercentage'
           
        ));
    }
}
