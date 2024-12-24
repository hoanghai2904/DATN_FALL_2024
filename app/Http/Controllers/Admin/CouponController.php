<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::paginate(10);
        return view('admin.coupon.index', ['coupons' => $coupons]);
    }

    public function new()
    {
        return view('admin.coupon.new');
    }

    public function save(Request $request)
    {
        // Validation dữ liệu
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:coupons',
            'description' => 'required',
            'discount_percentage' => 'required|numeric',
            'max_discount_amount' => 'required|numeric',
            'min_order_amount' => 'nullable|numeric',
            'start_end_date' => 'nullable',
        ]);
    
        // Loại bỏ dấu chấm trong giá trị max_discount_amount và min_order_amount nếu có
        $validated['max_discount_amount'] = str_replace('.', '', $validated['max_discount_amount']);
        if (isset($validated['min_order_amount'])) {
            $validated['min_order_amount'] = str_replace('.', '', $validated['min_order_amount']);
        }
    
        // Kiểm tra và xử lý ngày bắt đầu và ngày kết thúc
        if ($validated['start_end_date'] != null) {
            $dates = explode(' - ', $validated['start_end_date']);
            $start_date = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[0])->startOfDay()->format('Y-m-d');
            $end_date = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[1])->endOfDay()->format('Y-m-d');
    
            // Kiểm tra nếu ngày bắt đầu bé hơn ngày kết thúc
            if (\Carbon\Carbon::parse($start_date)->greaterThan(\Carbon\Carbon::parse($end_date))) {
                return redirect()->back()
                    ->withErrors(['start_end_date' => 'Ngày bắt đầu phải bé hơn hoặc bằng ngày kết thúc.'])
                    ->withInput(); // Gửi lại dữ liệu đã nhập vào form
            }
    
            unset($validated['start_end_date']);
        } else {
            $start_date = null;
            $end_date = null;
        }
    
        // Tạo mã giảm giá mới
        Coupon::create(array_merge($validated, ['start_date' => $start_date, 'end_date' => $end_date]));
    
        // Trả về thông báo thành công
        return redirect()->route('admin.coupon.index')->with(['alert' => [
            'type' => 'success',
            'title' => 'Thành Công',
            'content' => 'Thêm mã giảm giá thành công.'
        ]]);
    }
    

    public function delete(Request $request)
    {
        // Lấy coupon chưa bị xóa
        $coupon = Coupon::find($request->input('coupon_id'));
    
        // Kiểm tra nếu mã giảm giá không tồn tại
        if (!$coupon) {
            return response()->json([
                'type' => 'error',
                'title' => 'Thất Bại',
                'content' => 'Mã giảm giá không tồn tại.'
            ], 404); // Trả về mã lỗi 404
        }
    
        try {
            // Thực hiện xóa mã giảm giá
            $coupon->delete();  // Hoặc $coupon->forceDelete() để xóa hoàn toàn
    
            return response()->json([
                'type' => 'success',
                'title' => 'Thành Công',
                'content' => 'Xóa mã giảm giá thành công.'
            ], 200);  // Trả về mã 200 nếu thành công
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return response()->json([
                'type' => 'error',
                'title' => 'Lỗi',
                'content' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);  // Trả về mã lỗi 500 nếu có lỗi trong quá trình xóa
        }
    }
    
    

    public function edit($id)
    {
        $coupon = Coupon::find($id);

        return view('admin.coupon.edit', ['coupon' => $coupon]);
    }
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'code' => 'required|unique:coupons,code,' . $id,
                'description' => 'required',
                'discount_percentage' => 'required|numeric',
                'max_discount_amount' => 'required|numeric',
                'min_order_amount' => 'nullable|numeric',
                'start_end_date' => 'nullable',
            ]);
            
            // Loại bỏ dấu chấm trong giá trị max_discount_amount và min_order_amount nếu có
            $validated['max_discount_amount'] = str_replace('.', '', $validated['max_discount_amount']);
            if (isset($validated['min_order_amount'])) {
                $validated['min_order_amount'] = str_replace('.', '', $validated['min_order_amount']);
            }
            
            // Tìm coupon theo ID
            $coupon = Coupon::find($id);
            if (!$coupon) {
                return redirect()->route('admin.coupon.index')->with(['alert' => [
                    'type' => 'error',
                    'title' => 'Thất Bại',
                    'content' => 'Mã giảm giá không tồn tại.'
                ]]);
            }
    
            // Kiểm tra xem mã giảm giá có đang được sử dụng không
            $orders = Order::where('coupon_id', $id)->get();
            if ($orders->count() > 0) {
                return redirect()->route('admin.coupon.index')->with(['alert' => [
                    'type' => 'error',
                    'title' => 'Thất Bại',
                    'content' => 'Mã giảm giá đang được sử dụng, không thể cập nhật.'
                ]]);
            }
    
            // Xử lý ngày bắt đầu và ngày kết thúc nếu có
            if ($validated['start_end_date'] != null) {
                $dates = explode(' - ', $validated['start_end_date']);
                $start_date = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[0])->startOfDay()->format('Y-m-d');
                $end_date = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[1])->endOfDay()->format('Y-m-d');
                unset($validated['start_end_date']);
            } else {
                $start_date = null;
                $end_date = null;
            }
    
            // Cập nhật mã giảm giá
            $coupon->update(array_merge($validated, ['start_date' => $start_date, 'end_date' => $end_date]));
    
            return redirect()->route('admin.coupon.index')->with(['alert' => [
                'type' => 'success',
                'title' => 'Thành Công',
                'content' => 'Cập nhật mã giảm giá thành công.'
            ]]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
}
