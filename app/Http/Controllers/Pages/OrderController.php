<?php

namespace App\Http\Controllers\Pages;

use App\Enums\OrderStatusEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\Advertise;
use App\Mail\OrderStatusChanged;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
  private function sendStatusChangeEmail(Order $order, $newStatus)
  {
    $user = $order->user;
    Mail::to($user->email)->send(new OrderStatusChanged($order, $newStatus));
  }
  // public function index(Request $request)
  // {
  //   if (Auth::check() && Auth::user()->Role == 0) {
  //     $advertises = Advertise::where([
  //       ['start_date', '<=', date('Y-m-d')],
  //       ['end_date', '>=', date('Y-m-d')],
  //       ['at_home_page', '=', false]
  //     ])->latest()->limit(5)->get(['product_id', 'title', 'image']);

  //     $orders = Order::where('user_id', Auth::user()->id)->with([
  //       'payment_method' => function ($query) {
  //         $query->select('id', 'name');
  //       },
  //       'order_details' => function ($query) {
  //         $query->select('id', 'order_id', 'quantity', 'price');
  //       }
  //     ])->orderBy('created_at', 'DESC')->paginate(10);
  //     if ($orders->isNotEmpty()) {
  //       return view('pages.orders')->with('data', ['orders' => $orders, 'advertises' => $advertises]);
  //     } else {
  //       return redirect()->route('home_page')->with([
  //         'alert' => [
  //           'type' => 'info',
  //           'title' => 'Thông Báo',
  //           'content' => 'Bạn không có đơn hàng nào. Hãy mua hàng để thực hiện chức năng này!'
  //         ]
  //       ]);
  //     }
  //   } else if (Auth::check()) {
  //     return redirect()->route('admin.dashboard')->with([
  //       'alert' => [
  //         'type' => 'warning',
  //         'title' => 'Cảnh Báo',
  //         'content' => 'Bạn không có quyền truy cập vào trang này!'
  //       ]
  //     ]);
  //   } else {
  //     return redirect()->route('login')->with([
  //       'alert' => [
  //         'type' => 'warning',
  //         'title' => 'Cảnh Báo',
  //         'content' => 'Bạn phải đăng nhập để sử dụng chức năng này!'
  //       ]
  //     ]);
  //   }
  // }

  public function index(Request $request)
  {
      if (Auth::check() && Auth::user()->Role == 0) {
          // Lấy danh sách quảng cáo
          $advertises = Advertise::where([
              ['start_date', '<=', date('Y-m-d')],
              ['end_date', '>=', date('Y-m-d')],
              ['at_home_page', '=', false]
          ])->latest()->limit(5)->get(['product_id', 'title', 'image']);
  
          // Lấy danh sách đơn hàng của người dùng hiện tại
          $orders = Order::where('user_id', Auth::user()->id)
              ->with([
                  'payment_method' => function ($query) {
                      $query->select('id', 'name');
                  },
                  'order_details' => function ($query) {
                      $query->select('id', 'order_id', 'quantity', 'price');
                  }
              ])
              ->orderBy('created_at', 'DESC')
              ->paginate(10);
  
          // Kiểm tra các đơn hàng đã quá 5 phút và chưa thanh toán, nếu có thì hủy đơn hàng
          foreach ($orders as $order) {
              $this->cancelOrderIfOverdue($order->id);
          }
  
          // Kiểm tra xem người dùng có đơn hàng không
          if ($orders->isNotEmpty()) {
              return view('pages.orders')->with('data', ['orders' => $orders, 'advertises' => $advertises]);
          } else {
              return redirect()->route('home_page')->with([
                  'alert' => [
                      'type' => 'info',
                      'title' => 'Thông Báo',
                      'content' => 'Bạn không có đơn hàng nào. Hãy mua hàng để thực hiện chức năng này!'
                  ]
              ]);
          }
      } else if (Auth::check()) {
          return redirect()->route('admin.dashboard')->with([
              'alert' => [
                  'type' => 'warning',
                  'title' => 'Cảnh Báo',
                  'content' => 'Bạn không có quyền truy cập vào trang này!'
              ]
          ]);
      } else {
          return redirect()->route('login')->with([
              'alert' => [
                  'type' => 'warning',
                  'title' => 'Cảnh Báo',
                  'content' => 'Bạn phải đăng nhập để sử dụng chức năng này!'
              ]
          ]);
      }
  }

  public function show($id)
  {
    if (Auth::check() && Auth::user()->Role == 0) {
      // Lấy danh sách quảng cáo
      $advertises = Advertise::where([
        ['start_date', '<=', date('Y-m-d')],
        ['end_date', '>=', date('Y-m-d')],
        ['at_home_page', '=', false],
      ])->latest()->limit(5)->get(['product_id', 'title', 'image']);

      // Lấy thông tin đơn hàng
      $order = Order::where('id', $id)->with([
        'payment_method' => function ($query) {
          $query->select('id', 'name');
        },
        'user' => function ($query) {
          $query->select('id', 'name', 'email', 'phone', 'address');
        },
        'order_details' => function ($query) {
          $query->select('id', 'order_id', 'product_detail_id', 'quantity', 'price')
            ->with([
              'product_detail' => function ($query) {
                $query->select('id', 'product_id', 'color')
                  ->with([
                    'product' => function ($query) {
                      $query->select('id', 'name', 'image', 'sku_code');
                    },
                  ]);
              },
            ]);
        },
      ])->first();

      // Kiểm tra nếu đơn hàng không tồn tại
      if (!$order) {
        abort(404);
      }

      // Kiểm tra quyền truy cập của người dùng
      if (Auth::user()->id != $order->user_id) {
        return redirect()->route('home_page')->with([
          'alert' => [
            'type' => 'warning',
            'title' => 'Cảnh Báo',
            'content' => 'Bạn không có quyền truy cập vào trang này!',
          ],
        ]);
      }

      // Kiểm tra trạng thái và thời gian tạo đơn hàng
      if ($order->status === OrderStatusEnum::PENDING && $order->created_at->diffInHours(now()) >= 24) {
        // Hoàn lại sản phẩm về kho
        foreach ($order->order_details as $item) {
          $product = $item->product_detail->product;
          // dd($product);
          if ($product) {
            $product->stock += $item->quantity;
            $product->save();
          }
        }

        // Cập nhật trạng thái đơn hàng
        $order->status = 'cancelled';
        $order->save();
      }

      // Trả về view hiển thị thông tin đơn hàng
      return view('pages.order')->with('data', [
        'order' => $order,
        'advertises' => $advertises,
      ]);
    } else if (Auth::check()) {
      return redirect()->route('admin.dashboard')->with([
        'alert' => [
          'type' => 'warning',
          'title' => 'Cảnh Báo',
          'content' => 'Bạn không có quyền truy cập vào trang này!',
        ],
      ]);
    } else {
      return redirect()->route('login')->with([
        'alert' => [
          'type' => 'warning',
          'title' => 'Cảnh Báo',
          'content' => 'Bạn phải đăng nhập để sử dụng chức năng này!',
        ],
      ]);
    }
  }

  public function cancelOrder($id)
  {
    if (Auth::check() && Auth::user()->Role == 0) {
      $order = Order::where('id', $id)->first();
      if (!$order) {
        abort(404);
      }

      // Kiểm tra quyền truy cập
      if (Auth::user()->id != $order->user_id) {
        return redirect()->route('home_page')->with([
          'alert' => [
            'type' => 'warning',
            'title' => 'Cảnh Báo',
            'content' => 'Bạn không có quyền truy cập vào trang này!'
          ]
        ]);
      } else {
        // Kiểm tra trạng thái đơn hàng và thực hiện hủy nếu đơn hàng ở trạng thái có thể hủy
        if ($order->status == OrderStatusEnum::PENDING || $order->status == OrderStatusEnum::CONFIRMED || $order->status == OrderStatusEnum::PREPARING || $order->status == OrderStatusEnum::FAILED) {
          // Cập nhật trạng thái đơn hàng thành CANCELLED
          $order->status = OrderStatusEnum::CANCELLED;
          $order->save();

          // Cộng lại số lượng sản phẩm trong kho
          foreach ($order->order_details as $orderDetail) {
            $productDetail = $orderDetail->product_detail;

            // Kiểm tra nếu productDetail tồn tại
            if ($productDetail) {
              $productDetail->quantity += $orderDetail->quantity; // Cộng số lượng sản phẩm
              $productDetail->save();
            }
          }

          return response()->json(['status' => 'success', 'message' => 'Hủy đơn hàng thành công!']);
        } else {
          return response()->json(['status' => 'error', 'message' => 'Không thể hủy đơn hàng đã được xử lý!']);
        }
      }

    } else if (Auth::check()) {
      return redirect()->route('admin.dashboard')->with([
        'alert' => [
          'type' => 'warning',
          'title' => 'Cảnh Báo',
          'content' => 'Bạn không có quyền truy cập vào trang này!'
        ]
      ]);
    } else {
      return redirect()->route('login')->with([
        'alert' => [
          'type' => 'warning',
          'title' => 'Cảnh Báo',
          'content' => 'Bạn phải đăng nhập để sử dụng chức năng này!'
        ]
      ]);
    }
  }

  public function reciveOrder($id)
  {
    if (Auth::check() && Auth::user()->Role == 0) {
      $order = Order::where('id', $id)->first();
      if (!$order)
        abort(404);

      if (Auth::user()->id != $order->user_id) {
        return redirect()->route('home_page')->with([
          'alert' => [
            'type' => 'warning',
            'title' => 'Cảnh Báo',
            'content' => 'Bạn không có quyền truy cập vào trang này!'
          ]
        ]);
      } else {
        if ($order->status == OrderStatusEnum::DELIVERING) {
          $order->is_paid = true;
          $order->is_received = true;
          $order->status = OrderStatusEnum::COMPLETED;
          $order->save();
          return response()->json(['status' => 'success', 'message' => 'Nhận hàng thành công!']);
        } else {
          return response()->json(['status' => 'error', 'message' => 'Không thể nhận hàng khi đơn hàng chưa được giao!']);
        }
      }

    } else if (Auth::check()) {
      return redirect()->route('admin.dashboard')->with([
        'alert' => [
          'type' => 'warning',
          'title' => 'Cảnh Báo',
          'content' => 'Bạn không có quyền truy cập vào trang này!'
        ]
      ]);
    } else {
      return redirect()->route('login')->with([
        'alert' => [
          'type' => 'warning',
          'title' => 'Cảnh Báo',
          'content' => 'Bạn phải đăng nhập để sử dụng chức năng này!'
        ]
      ]);
    }
  }

  public function returnOrder(Request $request, $id)
  {
    // dd($request->all()); 
    if (Auth::check() && Auth::user()->admin == 0) {
      $order = Order::where('id', $id)->first();

      // Kiểm tra xem đơn hàng có tồn tại không
      if (!$order) {
        abort(404);  // Nếu không tìm thấy đơn hàng, trả về lỗi 404
      }

      // Kiểm tra quyền sở hữu đơn hàng
      if (Auth::user()->id != $order->user_id) {
        return redirect()->route('home_page')->with([
          'alert' => [
            'type' => 'warning',
            'title' => 'Cảnh Báo',
            'content' => 'Bạn không có quyền truy cập vào trang này!'
          ]
        ]);
      } else {
        // Kiểm tra trạng thái đơn hàng
        if ($order->status == OrderStatusEnum::DELIVERING || $order->status == OrderStatusEnum::COMPLETED) {
          // Xử lý logic khi người dùng yêu cầu hoàn hàng
          $order->status = OrderStatusEnum::RETURN_PENDING;  // Cập nhật trạng thái thành "Chờ xác nhận hoàn hàng"
          $order->return_reason = $request->input('return_reason');  // Lưu lý do hoàn hàng
          $order->save();

          return response()->json(['status' => 'success', 'message' => 'Yêu cầu hoàn hàng thành công!']);
        } else {
          return response()->json(['status' => 'error', 'message' => 'Không thể yêu cầu hoàn hàng khi đơn hàng chưa giao!']);
        }
      }
    } elseif (Auth::check()) {
      return redirect()->route('admin.dashboard')->with([
        'alert' => [
          'type' => 'warning',
          'title' => 'Cảnh Báo',
          'content' => 'Bạn không có quyền truy cập vào trang này!'
        ]
      ]);
    } else {
      return redirect()->route('login')->with([
        'alert' => [
          'type' => 'warning',
          'title' => 'Cảnh Báo',
          'content' => 'Bạn phải đăng nhập để sử dụng chức năng này!'
        ]
      ]);
    }
  }

  public function cancelOrderIfOverdue($orderId)
  {
      $order = Order::find($orderId);
  
      if ($order) {
          // Kiểm tra trạng thái đơn hàng đã hủy chưa
          if ($order->status != 8) {
              // Kiểm tra thời gian tạo đơn hàng
              $orderCreatedAt = Carbon::parse($order->created_at);
  
              // Kiểm tra nếu đơn hàng đã tồn tại hơn 1 phút, chưa thanh toán và có phương thức thanh toán trực tuyến (payment_method_id = 2)
              if ($orderCreatedAt->diffInHours(Carbon::now()) >= 24 && !$order->is_paid && $order->payment_method_id == 2) {
                  // Cập nhật trạng thái đơn hàng thành "Đã hủy"
                  $order->status = OrderStatusEnum::CANCELLED;
                  $order->save();
  
                  // Hoàn lại số lượng sản phẩm trong kho
                  foreach ($order->order_details as $orderDetail) {
                      $productDetail = $orderDetail->product_detail;
                      if ($productDetail) {
                          // Tăng số lượng sản phẩm trong kho
                          $productDetail->quantity += $orderDetail->quantity;
                          $productDetail->save();
                      }
                  }
              }
          }
      }
  }
  

}
