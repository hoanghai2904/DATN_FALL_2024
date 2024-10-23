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
    // Bắt đầu truy vấn
    $query = Order::query();
 
    // Lọc theo trạng thái đơn hàng
    if ($request->filled('status_order')) {
        $query->where('status_order', $request->status_order);
    }

    // Lọc theo mã đơn hàng
    if ($request->filled('order_code')) {
        $query->where('order_code', 'like', '%' . $request->order_code . '%');
    }

    // Lọc theo tên khách hàng
    if ($request->filled('user_name')) {
        $query->where('user_name', 'like', '%' . $request->user_name . '%');
    }

   // Khoảng thời gian
        if ($request->filled('start_date') && $request->filled('end_date')) {
            // Chuyển đổi định dạng ngày để phù hợp
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();

            // Lọc theo khoảng thời gian
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }


    // Lọc theo tìm kiếm chung
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($query) use ($search) {
            $query->where('order_code', 'like', '%' . $search . '%')
                  ->orWhere('user_name', 'like', '%' . $search . '%')
                  ->orWhere('user_email', 'like', '%' . $search . '%')
                  ->orWhere('status_order', 'like', '%' . $search . '%');
        });
    }

    // Lấy danh sách đơn hàng sau khi lọc
    $orders = $query->paginate(10);

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

        $totalAmount = $orderItems->sum(function ($item) {
            return $item->product_price_sale ? $item->product_price_sale * $item->qty : $item->product_price * $item->qty;
        });
    
        // Cập nhật tổng tiền vào bảng orders (nếu cần)
        $order->total_price = $totalAmount; // Giả sử bạn đã có trường total_price trong bảng orders
        $order->save(); // Lưu thay đổi vào cơ sở dữ liệu
    
        return view('admin.orders.show', compact('order', 'orderItems', 'totalAmount'));
    }

    // Chỉnh sửa đơn hàng
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    // Cập nhật đơn hàng
    public function update(Request $request, Order $order)
    {
        // Validate the incoming request
        $request->validate([
            'status_order' => 'required|string', // Thêm xác thực cho trạng thái
            // Các xác thực khác nếu cần
        ]);
    
        // Kiểm tra nếu trạng thái mới là "Hoàn thành"
        if ($request->input('status_order') === 'Hoàn thành') {
            $order->payment_method = 'Đã thanh toán'; // Cập nhật phương thức thanh toán
        }
    
        // Cập nhật các trường khác của đơn hàng
        $order->update($request->except('payment_method')); // Bỏ qua payment_method nếu nó được cập nhật trong điều kiện trên
    
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