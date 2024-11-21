<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
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
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:coupons',
            'description' => 'required',
            'discount_percentage' => 'required|numeric',
            'max_discount_amount' => 'required|numeric',
            'min_order_amount' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $coupon = new Coupon();
        $coupon->name = $request->input('name');
        $coupon->code = $request->input('code');
        $coupon->description = $request->input('description');
        $coupon->discount_percentage = $request->input('discount_percentage');
        $coupon->max_discount_amount = $request->input('max_discount_amount');
        $coupon->min_order_amount = $request->input('min_order_amount');
        $coupon->start_date = $request->input('start_date');
        $coupon->end_date = $request->input('end_date');
        $coupon->save();

        return redirect()->route('admin.coupon.index')->with(['alert' => [
            'type' => 'success',
            'title' => 'Thành Công',
            'content' => 'Thêm mã giảm giá thành công.'
        ]]);
    }

    public function delete(Request $request)
    {
        $coupon = Coupon::find($request->input('id'));
        $coupon->delete();

        return response()->json([
            'type' => 'success',
            'title' => 'Thành Công',
            'content' => 'Xóa mã giảm giá thành công.'
        ]);
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);

        return view('admin.coupon.edit', ['coupon' => $coupon]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:coupons,code,' . $id,
            'description' => 'required',
            'discount_percentage' => 'required|numeric',
            'max_discount_amount' => 'required|numeric',
            'min_order_amount' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $coupon = Coupon::find($id);
        $coupon->name = $request->input('name');
        $coupon->code = $request->input('code');
        $coupon->description = $request->input('description');
        $coupon->discount_percentage = $request->input('discount_percentage');
        $coupon->max_discount_amount = $request->input('max_discount_amount');
        $coupon->min_order_amount = $request->input('min_order_amount');
        $coupon->start_date = $request->input('start_date');
        $coupon->end_date = $request->input('end_date');
        $coupon->save();

        return redirect()->route('admin.coupon.index')->with(['alert' => [
            'type' => 'success',
            'title' => 'Thành Công',
            'content' => 'Cập nhật mã giảm giá thành công.'
        ]]);
    }
}
