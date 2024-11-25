<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;

class CheckPendingOrder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('pending_order_id')) {
            $orderId = session('pending_order_id');
            $order = Order::find($orderId);

            if ($order) {
                $order->order_details()->delete();
                $order->delete();
            }

            session()->forget('pending_order_id');
        }

        return $next($request);
    }
}
