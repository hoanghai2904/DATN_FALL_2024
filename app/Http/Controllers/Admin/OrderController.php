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
      ])->where('status', 1)->latest()->get();
    return view('admin.order.index')->with('orders', $orders);
  }

  // public function show($id)
  // {
  //   $order = Order::select('id', 'user_id', 'discount', 'payment_method_id','fee','is_paid', 'order_code', 'name', 'email', 'phone', 'address', 'created_at')->where([['status', '<>', 0], ['id', $id]])->with([
  //       'user' => function ($query) {
  //         $query->select('id', 'name', 'email', 'phone', 'address');
  //       },
  //       'payment_method' => function ($query) {
  //         $query->select('id', 'name', 'describe');
  //       },
  //       'order_details' => function($query) {
  //         $query->select('id', 'order_id', 'product_detail_id', 'quantity', 'price')
  //         ->with([
  //           'product_detail' => function ($query) {
  //             $query->select('id', 'product_id', 'color', 'size')
  //             ->with([
  //               'product' => function ($query) {
  //                 $query->select('id', 'name', 'image', 'sku_code');
  //               }
  //             ]);
  //           }
  //         ]);
  //       }
  //     ])->first();
  //   if(!$order) abort(404);
  //   return view('admin.order.show')->with('order', $order);
  // }
  public function show($id)
  {
      $order = Order::withTrashed() // Lấy cả đơn hàng đã bị xóa mềm
          ->select('id', 'user_id', 'discount', 'payment_method_id', 'fee', 'is_paid', 'order_code', 'name', 'email', 'phone', 'address', 'created_at')
          ->where([['status', '<>', 0], ['id', $id]])
          ->with([
              'user' => function ($query) {
                  $query->select('id', 'name', 'email', 'phone', 'address');
              },
              'payment_method' => function ($query) {
                  $query->select('id', 'name', 'describe');
              },
              'order_details' => function($query) {
                  $query->withTrashed() // Áp dụng cho order_details
                      ->select('id', 'order_id', 'product_detail_id', 'quantity', 'price')
                      ->with([
                          'product_detail' => function ($query) {
                              $query->withTrashed() // Áp dụng cho product_detail
                                  ->select('id', 'product_id', 'color', 'size')
                                  ->with([
                                      'product' => function ($query) {
                                          $query->withTrashed() // Áp dụng cho product
                                              ->select('id', 'name', 'image', 'sku_code');
                                      }
                                  ]);
                          }
                      ]);
              }
          ])->first();
          
      if(!$order) abort(404);
      return view('admin.order.show')->with('order', $order);
  }
  
  public function actionTransaction($action, $id)
  {
      $orderAction = Order::find($id);
      if ($orderAction) {
          switch ($action) {
              case 'confirmed':
                  $orderAction->status = OrderStatusEnum::CONFIRMED;
                  break;
              case 'preparing':
                  $orderAction->status = OrderStatusEnum::PREPARING;
                  break;
              case 'delivering':
                  $orderAction->status = OrderStatusEnum::DELIVERING;
                  break;
              case 'delivered':
                  $orderAction->status = OrderStatusEnum::DELIVERED;
                  break;
              case 'completed':
                  $orderAction->status = OrderStatusEnum::COMPLETED;
                  break;
              case 'failed':
                  $orderAction->status = OrderStatusEnum::FAILED;
                  break;
              case 'cancel':
                  $orderAction->status = OrderStatusEnum::CANCELLED;
                  break;
              default:
                  return redirect()->back()->with('error', 'Lỗi');
          }
          // Lưu vào CSDL
          $orderAction->save();
      }
  
      return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
  }

  public function processing(){
    $orders = Order::select('id', 'user_id','status','is_paid', 'payment_method_id','status', 'order_code', 'name', 'email', 'phone', 'created_at')->with([
      'user' => function ($query) {
        $query->select('id', 'name');
      },
      'payment_method' => function ($query) {
        $query->select('id', 'name'); 
      }
    ])->where('status', 2)->latest()->get();

    $preOrders = Order::select('id', 'user_id','status','is_paid', 'payment_method_id','status', 'order_code', 'name', 'email', 'phone', 'created_at')->with([
      'user' => function ($query) {
        $query->select('id', 'name');
      },
      'payment_method' => function ($query) {
        $query->select('id', 'name'); 
      }
    ])->where('status', 3)->latest()->get();

  return view('admin.order.processing',compact('orders','preOrders'));
  }
  public function completed(){
    $deliveringOrders = Order::select('id', 'user_id','status','is_paid', 'payment_method_id','status', 'order_code', 'name', 'email', 'phone', 'created_at')->with([
      'user' => function ($query) {
        $query->select('id', 'name');
      },
      'payment_method' => function ($query) {
        $query->select('id', 'name'); 
      }
    ])->where('status', 4)->latest()->get();

    $deliveredOrders = Order::select('id', 'user_id','status','is_paid', 'payment_method_id','status', 'order_code', 'name', 'email', 'phone', 'created_at')->with([
      'user' => function ($query) {
        $query->select('id', 'name');
      },
      'payment_method' => function ($query) {
        $query->select('id', 'name'); 
      }
    ])->where('status', 5)->latest()->get();
    $completedOrders = Order::select('id', 'user_id','status','is_paid', 'payment_method_id','status', 'order_code', 'name', 'email', 'phone', 'created_at')->with([
      'user' => function ($query) {
        $query->select('id', 'name');
      },
      'payment_method' => function ($query) {
        $query->select('id', 'name'); 
      }
    ])->where('status', 6)->latest()->get();

    $failedOrders = Order::select('id', 'user_id','status','is_paid', 'payment_method_id','status', 'order_code', 'name', 'email', 'phone', 'created_at')->with([
      'user' => function ($query) {
        $query->select('id', 'name');
      },
      'payment_method' => function ($query) {
        $query->select('id', 'name'); 
      }
    ])->where('status', 7)->latest()->get();

    $cancelledOrders = Order::select('id', 'user_id','status','is_paid', 'payment_method_id','status', 'order_code', 'name', 'email', 'phone', 'created_at')->with([
      'user' => function ($query) {
        $query->select('id', 'name');
      },
      'payment_method' => function ($query) {
        $query->select('id', 'name'); 
      }
    ])->where('status', 8)->latest()->get();

  return view('admin.order.completed',compact('deliveringOrders','deliveredOrders','completedOrders','failedOrders','cancelledOrders'));
  }
}
