<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
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
        $orders = Order::paginate(10);
        // Trả về view với danh sách đơn hàng
        return view('admin.orders.index', compact('orders'));
    }
    
    
    
    

    // Tạo đơn hàng mới
    public function create()
    {
        return view('admin.orders.create');
    }

    // Hiển thị chi tiết đơn hàng
    public function show($id)
{
    $order = Order::with('items','payment')->findOrFail($id);
    
    // Kiểm tra nếu đơn hàng có liên kết với user
    $customer = $order->user_id 
        ? User::find($order->user_id) // Nếu có user_id, lấy thông tin từ User
        : (object) [ // Nếu không, dùng thông tin trong đơn hàng
            'name' => $order->user_name,
            'email' => $order->user_email,
            'phone' => $order->user_phone,
            'address' => $order->user_address,
        ];
    
    // Chỉ gọi addresses() nếu $customer là một đối tượng User
    $addresses = isset($customer->addresses) 
        ? $customer->addresses()->get() 
        : collect(); // Trả về một collection rỗng nếu không có user_id

    return view('admin.orders.show', compact('order', 'customer', 'addresses'));
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
    
    public function showInvoice($id)
    {
        $order = Order::findOrFail($id);
        // Lấy thông tin các sản phẩm liên quan
        $orderItems = $order->items; // Đảm bảo rằng bạn đã thiết lập quan hệ items
    
        return view('admin.orders.invoice', compact('order', 'orderItems'));
    }
    // Xóa đơn hàng
    public function destroy($id)
{
    $order = Order::find($id);
    if ($order) {
        $order->delete();
        return response()->json(['status' => 'success', 'message' => 'Đơn hàng đã được xóa!']);
    }
    return response()->json(['status' => 'error', 'message' => 'Không tìm thấy đơn hàng!']);
}
}