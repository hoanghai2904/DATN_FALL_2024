<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{
  public function index()
  {
    $orders = Order::select('id', 'user_id','status','is_paid', 'payment_method_id','status', 'order_code', 'name', 'email', 'phone', 'created_at')->with([
        'user' => function ($query) {
          $query->select('id', 'name');
        },
        'payment_method' => function ($query) {
          $query->select('id', 'name');
        }
      ])->latest()->get();
    return view('admin.order.index')->with('orders', $orders);
  }

  public function show($id)
  {
    $order = Order::select('id', 'user_id', 'discount', 'payment_method_id','fee','is_paid', 'order_code', 'name', 'email', 'phone', 'address', 'created_at')->where([['status', '<>', 0], ['id', $id]])->with([
        'user' => function ($query) {
          $query->select('id', 'name', 'email', 'phone', 'address');
        },
        'payment_method' => function ($query) {
          $query->select('id', 'name', 'describe');
        },
        'order_details' => function($query) {
          $query->select('id', 'order_id', 'product_detail_id', 'quantity', 'price')
          ->with([
            'product_detail' => function ($query) {
              $query->select('id', 'product_id', 'color', 'size')
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
    return view('admin.order.show')->with('order', $order);
  }

  public function actionTransaction($action,$id){
    $orderAction = Order::find($id);
    if($orderAction){
      switch ($action) {
        case 'confirmed':
          $orderAction->status= OrderStatusEnum::CONFIRMED;
          break;
        case 'delivering':
          $orderAction->status= OrderStatusEnum::DELIVERING;
          break;
        case 'delivered':
          $orderAction->status= OrderStatusEnum::DELIVERED;
          break;
        case 'cancel':
          $orderAction->status= OrderStatusEnum::CANCELLED;
          break;
      }
      $orderAction->save();
    }
    return redirect()->back();
  }
}
