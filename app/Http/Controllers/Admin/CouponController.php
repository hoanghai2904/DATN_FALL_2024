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
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:coupons',
            'description' => 'required',
            'discount_percentage' => 'required|numeric',
            'max_discount_amount' => 'required|numeric',
            'min_order_amount' => 'nullable|numeric',
            'start_end_date' => 'nullable',
        ]);
        $validated['max_discount_amount'] = str_replace('.', '', $validated['max_discount_amount']);
        if (isset($validated['min_order_amount'])) {
            $validated['min_order_amount'] = str_replace('.', '', $validated['min_order_amount']);
        }
        if ($validated['start_end_date'] != null) {
            $dates = explode(' - ', $validated['start_end_date']);
            $start_date = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[0])->format('Y-m-d');
            $end_date = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[1])->format('Y-m-d');
            unset($validated['start_end_date']);
        } else {
            $start_date = null;
            $end_date = null;
        }

        Coupon::create(array_merge($validated, ['start_date' => $start_date, 'end_date' => $end_date]));

        return redirect()->route('admin.coupon.index')->with(['alert' => [
            'type' => 'success',
            'title' => 'Thành Công',
            'content' => 'Thêm mã giảm giá thành công.'
        ]]);
    }

    // public function delete(Request $request)
    // {
    //     $coupon = Coupon::find($request->input('coupon_id'));
    //     if (!$coupon) {
    //         return response()->json([
    //             'type' => 'error',
    //             'title' => 'Thất Bại',
    //             'content' => 'Mã giảm giá không tồn tại.'
    //         ]);
    //     }
    //     $orders = Order::where('coupon_id', operator: $coupon->id)->get();
    //     if ($orders->count() > 0) {
    //         return response()->json([
    //             'type' => 'error',
    //             'title' => 'Thất Bại',
    //             'content' => 'Mã giảm giá đang được sử dụng, không thể xóa.'
    //         ]);
    //     }
    //     $coupon->delete();

    //     return response()->json([
    //         'type' => 'success',
    //         'title' => 'Thành Công',
    //         'content' => 'Xóa mã giảm giá thành công.'
    //     ]);
    // }
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
            $validated['max_discount_amount'] = str_replace('.', '', $validated['max_discount_amount']);
            if (isset($validated['min_order_amount'])) {
                $validated['min_order_amount'] = str_replace('.', '', $validated['min_order_amount']);
            }
            $coupon = Coupon::find($id);
            if (!$coupon) {
                return redirect()->route('admin.coupon.index')->with(['alert' => [
                    'type' => 'error',
                    'title' => 'Thất Bại',
                    'content' => 'Mã giảm giá không tồn tại.'
                ]]);
            }
            $orders = Order::where('coupon_id', $id)->get();
            if ($orders->count() > 0) {
                return redirect()->route('admin.coupon.index')->with(['alert' => [
                    'type' => 'error',
                    'title' => 'Thất Bại',
                    'content' => 'Mã giảm giá đang được sử dụng, không thể cập nhật.'
                ]]);
            }
            if ($validated['start_end_date'] != null) {
                $dates = explode(' - ', $validated['start_end_date']);
                $start_date = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[0])->format('Y-m-d');
                $end_date = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[1])->format('Y-m-d');
                unset($validated['start_end_date']);
            } else {
                $start_date = null;
                $end_date = null;
            }
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
