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
        // Bắt đầu truy vấn với quan hệ users và user_addresses
        $query = Order::with(['user', 'user.addresses']);
    
      // Lọc theo trạng thái đơn hàng
if ($request->filled('order_status')) {
    $query->where('order_status', $request->order_status);
}

// Lọc theo trạng thái thanh toán
if ($request->filled('payment_status')) {
    $query->where('payment_status', $request->payment_status);
}

// Lọc theo khoảng thời gian
if ($request->filled('start_date') && $request->filled('end_date')) {
    $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
    $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();

    $query->whereBetween('created_at', [$startDate, $endDate]);
} elseif ($request->filled('start_date')) {
    $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
    $query->where('created_at', '>=', $startDate);
} elseif ($request->filled('end_date')) {
    $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();
    $query->where('created_at', '<=', $endDate);
}

// Lọc theo tìm kiếm chung
if ($request->filled('search')) {
    $search = $request->search;
    $query->where(function ($query) use ($search) {
        $query->where('order_code', 'like', '%' . $search . '%');
    
              
    });
}
        // Lấy danh sách đơn hàng sau khi lọc
        $orders = $query->paginate(7)->appends($request->except('page'));
    
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
    public function update(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'order_status' => 'required|string',
            'payment_status' => 'required|string',
        ]);
    
        // Tìm đơn hàng theo ID
        $order = Order::findOrFail($id);
    
        // Cập nhật trạng thái
        $order->order_status = $request->order_status;
        $order->payment_status = $request->payment_status;
        $order->save();
    
        return response()->json(['success' => true, 'message' => 'Cập nhật trạng thái đơn hàng thành công!']);
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