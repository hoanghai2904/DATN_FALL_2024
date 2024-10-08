<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index()
    {
        $orders = Order::all();
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
        $orderItems = $order->orderItems;
    
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

