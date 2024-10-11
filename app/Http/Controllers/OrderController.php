<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon; 
class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('status_order')) {
            $query->where('status_order', $request->status_order);
        }
    
        
        if ($request->has('order_code') && !empty($request->input('order_code'))) {
            $query->where('order_code', 'like', '%' . $request->input('order_code') . '%');
        }
        // Kiểm tra và lọc theo tên khách hàng
        if ($request->has('user_name') && !empty($request->user_name)) {
            $query->where('user_name', 'like', '%' . $request->user_name . '%');
        }
       if ($request->filled('month')) {
        $query->whereMonth('created_at', Carbon::parse($request->month)->month)
              ->whereYear('created_at', Carbon::parse($request->month)->year);
    }

        // Kiểm tra và lọc theo tìm kiếm chung
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($query) use ($search) {
                $query->where('order_code', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_email', 'like', '%' . $search . '%')
                    ->orWhere('status_order', 'like', '%' . $search . '%');
            });
        }
    
        // Lấy danh sách đơn hàng sau khi lọc
        $orders = $query->get();
    
        // Trả về view với danh sách đơn hàng
        return view('admin.orders.index', compact('orders'));
    }
    

    // Tạo đơn hàng mới
    public function create()
    {
        return view('admin.orders.create');
    }

    // Lưu đơn hàng mới
    public function store(Request $request)
    {
        $order = Order::create($request->all());
        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully');
    }

    // Hiển thị chi tiết đơn hàng
    public function show(Order $order)
    {
        // Lấy các sản phẩm trong đơn hàng bằng quan hệ đã thiết lập
        $orderItems = $order->items;

        return view('admin.orders.show', compact('order', 'orderItems'));
    }

    // Chỉnh sửa đơn hàng
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    // Cập nhật đơn hàng
    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully');
    }

    // Xóa đơn hàng
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully');
    }
}