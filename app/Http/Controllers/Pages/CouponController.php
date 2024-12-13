<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Advertise;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index()
    {
        $advertises = Advertise::where([
            ['start_date', '<=', date('Y-m-d')],
            ['end_date', '>=', date('Y-m-d')],
            ['at_home_page', '=', false]
          ])->latest()->limit(5)->get(['product_id', 'title', 'image']);
        $coupons = Coupon::all();
        $savedCoupons = [];

        if (Auth::check()) {
            $user = Auth::user();
            $savedCoupons = $user->coupons()->pluck('coupon_id')->toArray();
        }

        return view('pages.coupon', [
            'coupons' => $coupons,
            'savedCoupons' => $savedCoupons,
            'advertises' => $advertises
        ]);
    }
    public function getUserCoupons()
    {
        $user = Auth::user();
        $userCoupons = $user->userCoupons()->with('coupon')->where('is_used', false)
        ->where('used_at', null)->get();
        $coupons = $userCoupons->map(function ($userCoupon) {
            return [
                'id' => $userCoupon?->coupon?->id,
                'code' => $userCoupon?->coupon?->code,
                'discount_percentage' => $userCoupon?->coupon?->discount_percentage,
                'max_discount_amount' => $userCoupon?->coupon?->max_discount_amount,
                'min_order_amount' => $userCoupon?->coupon?->min_order_amount,
                'start_date' => $userCoupon?->coupon?->start_date,
                'end_date' => $userCoupon?->coupon?->end_date,
                'description' => $userCoupon?->coupon?->description,
            ];
        });
 // Assuming the user has a relationship with coupons
        return response()->json(['coupons' => $coupons]);
    }
    public function validateCoupon(Request $request)
    {
        $couponId = $request->input('coupon_id');
        $totalPrice = $request->input('total_price');

        $userCoupon = Auth::user()->userCoupons()->with('coupon')->where('coupon_id', $couponId)->first();

        if (!$userCoupon) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ.']);
        }

        $coupon = $userCoupon->coupon;

        $currentDate = now();
        if (($coupon?->start_date && $currentDate < $coupon->start_date) || ($coupon?->end_date && $currentDate > $coupon->end_date)) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá đã hết hạn hoặc chưa đến thời gian sử dụng.']);
        }

        if ($totalPrice < $coupon->min_order_amount) {
            return response()->json(['success' => false, 'message' => 'Đơn hàng của bạn không đủ để sử dụng mã giảm giá này.']);
        }

        $discountAmount = ($totalPrice * $coupon->discount_percentage) / 100;
        if ($discountAmount > $coupon->max_discount_amount) {
            $discountAmount = $coupon->max_discount_amount;
        }

        $finalPrice = $totalPrice - $discountAmount;

        return response()->json(['success' => true,'coupon_id' => $couponId, 'discount_amount' => $discountAmount, 'final_price' => $finalPrice]);
    }

    public function saveCoupon(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'not_logged_in']);
        }

        $user = Auth::user();
        $couponId = $request->input('coupon_id');

        // Check if the coupon is already saved
        if ($user->coupons()->where('coupon_id', $couponId)->exists()) {
            return response()->json(['status' => 'already_saved']);
        }

        // Save the coupon
        $user->coupons()->attach($couponId);

        return response()->json(['status' => 'success']);
    }
}
