<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function getUserCoupons()
    {
        $user = Auth::user();
        $userCoupons = $user->userCoupons()->with('coupon')->get();
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
            return response()->json(['success' => false, 'message' => 'Coupon not found.']);
        }

        $coupon = $userCoupon->coupon;

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
}
