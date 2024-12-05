<?php

namespace App\Http\Controllers\Pages;

use App\Enums\OrderStatusEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\Advertise;

class OrderController extends Controller
{
  public function index(Request $request)
  {
    if(Auth::check() && Auth::user()->admin == 0) {
      $advertises = Advertise::where([
        ['start_date', '<=', date('Y-m-d')],
        ['end_date', '>=', date('Y-m-d')],
        ['at_home_page', '=', false]
      ])->latest()->limit(5)->get(['product_id', 'title', 'image']);

      $orders = Order::where('user_id', Auth::user()->id)->with([
        'payment_method' => function ($query) {
          $query->select('id', 'name');
        },
        'order_details' => function($query) {
          $query->select('id', 'order_id', 'quantity', 'price');
        }
      ])->orderBy('created_at', 'DESC')->paginate(10);
      if($orders->isNotEmpty()) {
        return view('pages.orders')->with('data',['orders' => $orders, 'advertises' => $advertises]);
      } else {
        return redirect()->route('home_page')->with(['alert' => [
          'type' => 'info',
          'title' => 'Thông Báo',
          'content' => 'Bạn không có đơn hàng nào. Hãy mua hàng để thực hiện chức năng này!'
        ]]);
      }
    } else if(Auth::check()) {
      return redirect()->route('admin.dashboard')->with(['alert' => [
        'type' => 'warning',
        'title' => 'Cảnh Báo',
        'content' => 'Bạn không có quyền truy cập vào trang này!'
      ]]);
    } else {
      return redirect()->route('login')->with(['alert' => [
        'type' => 'warning',
        'title' => 'Cảnh Báo',
        'content' => 'Bạn phải đăng nhập để sử dụng chức năng này!'
      ]]);
    }
  }

  public function show($id)
  {
    if(Auth::check() && Auth::user()->admin == 0) {
      $advertises = Advertise::where([
        ['start_date', '<=', date('Y-m-d')],
        ['end_date', '>=', date('Y-m-d')],
        ['at_home_page', '=', false]
      ])->latest()->limit(5)->get(['product_id', 'title', 'image']);

      $order = Order::where('id', $id)->with([
        'payment_method' => function($query) {
          $query->select('id', 'name');
        },
        'user' => function($query) {
          $query->select('id', 'name',  'email', 'phone', 'address');
        },
        'order_details' => function($query) {
          $query->select('id', 'order_id', 'product_detail_id', 'quantity', 'price')
          ->with([
            'product_detail' => function ($query) {
              $query->select('id', 'product_id', 'color')
              ->with([
                'product' => function ($query) {
                  $query->select('id', 'name', 'image', 'sku_code');
                }
              ]);
            }
          ]);
        }
      ])->first();

      if(!$order) abort(404);

      if(Auth::user()->id != $order->user_id) {
        return redirect()->route('home_page')->with(['alert' => [
          'type' => 'warning',
          'title' => 'Cảnh Báo',
          'content' => 'Bạn không có quyền truy cập vào trang này!'
        ]]);
      } else {
        return view('pages.order')->with('data',['order' => $order, 'advertises' => $advertises]);
      }

    } else if(Auth::check()) {
      return redirect()->route('admin.dashboard')->with(['alert' => [
        'type' => 'warning',
        'title' => 'Cảnh Báo',
        'content' => 'Bạn không có quyền truy cập vào trang này!'
      ]]);
    } else {
      return redirect()->route('login')->with(['alert' => [
        'type' => 'warning',
        'title' => 'Cảnh Báo',
        'content' => 'Bạn phải đăng nhập để sử dụng chức năng này!'
      ]]);
    }
  }

  public function cancelOrder($id)
  {
    if(Auth::check() && Auth::user()->admin == 0) {
      $order = Order::where('id', $id)->first();
      if(!$order) abort(404);

      if(Auth::user()->id != $order->user_id) {
        return redirect()->route('home_page')->with(['alert' => [
          'type' => 'warning',
          'title' => 'Cảnh Báo',
          'content' => 'Bạn không có quyền truy cập vào trang này!'
        ]]);
      } else {
        if($order->status == OrderStatusEnum::PENDING || $order->status == OrderStatusEnum::NOT_PAID) {
          $order->status = OrderStatusEnum::CANCELLED;
          $order->save();
          return response()->json(['status' => 'success', 'message' => 'Hủy đơn hàng thành công!']);
        } else {
          return response()->json(['status' => 'error', 'message' => 'Không thể hủy đơn hàng đã được xử lý!']);
        }
      }

    } else if(Auth::check()) {
      return redirect()->route('admin.dashboard')->with(['alert' => [
        'type' => 'warning',
        'title' => 'Cảnh Báo',
        'content' => 'Bạn không có quyền truy cập vào trang này!'
      ]]);
    } else {
      return redirect()->route('login')->with(['alert' => [
        'type' => 'warning',
        'title' => 'Cảnh Báo',
        'content' => 'Bạn phải đăng nhập để sử dụng chức năng này!'
      ]]);
    }
  }

  public function reciveOrder($id)
  {
    if(Auth::check() && Auth::user()->admin == 0) {
      $order = Order::where('id', $id)->first();
      if(!$order) abort(404);

      if(Auth::user()->id != $order->user_id) {
        return redirect()->route('home_page')->with(['alert' => [
          'type' => 'warning',
          'title' => 'Cảnh Báo',
          'content' => 'Bạn không có quyền truy cập vào trang này!'
        ]]);
      } else {
        if($order->status == OrderStatusEnum::DELIVERED) {
          $order->is_paid = true;
          $order->is_received = true;
          $order->save();
          return response()->json(['status' => 'success', 'message' => 'Nhận hàng thành công!']);
        } else {
          return response()->json(['status' => 'error', 'message' => 'Không thể nhận hàng khi đơn hàng chưa được giao!']);
        }
      }

    } else if(Auth::check()) {
      return redirect()->route('admin.dashboard')->with(['alert' => [
        'type' => 'warning',
        'title' => 'Cảnh Báo',
        'content' => 'Bạn không có quyền truy cập vào trang này!'
      ]]);
    } else {
      return redirect()->route('login')->with(['alert' => [
        'type' => 'warning',
        'title' => 'Cảnh Báo',
        'content' => 'Bạn phải đăng nhập để sử dụng chức năng này!'
      ]]);
    }
  }
}
