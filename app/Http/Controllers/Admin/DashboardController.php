<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

use App\Models\User;
use App\Models\Post;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Producer;
use Carbon\Carbon;

class DashboardController extends Controller
{
  public function dashboardData()
  {
    $carbon = new Carbon('first day of this month');

    $count_products = 0;
    $total_revenue = 0;
    $total_profit = 0;

    for ($i = 0; $i < $carbon->daysInMonth; $i++) {

      $date = $carbon->copy()->addDay($i)->format('d/m/Y');

      $data['labels'][] = $date;

      $order_details = OrderDetail::withTrashed()->select('id', 'order_id', 'product_detail_id', 'quantity', 'price', 'created_at')
      ->whereDate('created_at', $carbon->copy()->addDay($i)->format('Y-m-d'))
      ->whereHas('order', function (Builder $query) {
        $query->withTrashed()->where('status', '=', OrderStatusEnum::COMPLETED);
      })->with([
        'order' => function ($query) {
          $query->withTrashed()->select('id', 'order_code','discount');
        },
        'variants' => function ($query) {
          $query->withTrashed()->select('id', 'purchase_price','promotion_price');
        }
      ])->latest()->get();
        // dd($order_details);
      $revenue = 0;
      $profit = 0;

      foreach ($order_details as $order_detail) {
        $revenue = $revenue + $order_detail->price * $order_detail->quantity - $order_detail->order->discount;
        $profit = $profit + ($order_detail->quantity * ($order_detail->price - $order_detail->variants->purchase_price)) - ($order_detail->order->discount);
        $count_products = $count_products + $order_detail->quantity;
      }

      $total_revenue = $total_revenue + $revenue;
      $total_profit = $total_profit + $profit;
      $data['revenues'][] = $revenue;
    }

    $data['count_products'] = $count_products;
    $data['total_revenue'] = $total_revenue;
    $data['total_profit'] = $total_profit;
    $data['count_orders'] = Order::where('status', '=', OrderStatusEnum::COMPLETED)
      ->whereYear('created_at', $carbon->year)
      ->whereMonth('created_at', $carbon->month)->count();

    $order_details = OrderDetail::withTrashed()->select('id', 'order_id', 'product_detail_id', 'quantity', 'price', 'created_at')->whereYear('created_at', $carbon->year)->whereMonth('created_at', $carbon->month)
      ->whereHas('order', function (Builder $query) {
        $query->withTrashed()->where('status', '=', OrderStatusEnum::COMPLETED);
      })->with([
        'order' => function ($query) {
          $query->withTrashed()->select('id', 'order_code', 'discount');
        },
        'variants' => function ($query) {
          $query->withTrashed()->select('id', 'product_id', 'attributes','sku' ,'purchase_price')->with([
            'product' => function ($query) {
              $query->withTrashed()->select('id', 'producer_id', 'name', 'sku_code')->with([
                'producer' => function ($query) {
                  $query->withTrashed()->select('id', 'name');
                }
              ]);
            }
          ]);
        }
      ])->latest()->get();

    $data['order_details'] = $order_details;

    $producers = Producer::select('name')->has('products')->get();

    foreach ($producers as $producer) {
      $data['producer'][$producer->name]['quantity'] = 0;
      $data['producer'][$producer->name]['revenue'] = 0;
      $data['producer'][$producer->name]['profit'] = 0;
    }
    // dd($order_detail);

    foreach ($order_details as $order_detail) {
      $producerName = $order_detail->variants->product->producer->name ?? 'Không thấy danh mục';
  
      $data['producer'][$producerName]['quantity'] = ($data['producer'][$producerName]['quantity'] ?? 0) + $order_detail->quantity;
      $data['producer'][$producerName]['revenue'] = ($data['producer'][$producerName]['revenue'] ?? 0) + $order_detail->quantity * $order_detail->price;
      $data['producer'][$producerName]['profit'] = ($data['producer'][$producerName]['profit'] ?? 0) + $order_detail->quantity * ($order_detail->price - ($order_detail->variants->purchase_price ?? 0));
    }
  // dd($data);  
    return $data;
  }
  

  public function orderGroupByStatus()
  {
    $data = Order::select('status')
      ->selectRaw('count(id) as count')
      ->groupBy('status')
      ->get();

    // Map the status counts to their corresponding status names
    $statusCounts = $data->map(function ($item) {
      return [
        'status' => OrderStatusEnum::getStatus()[$item->status],
        'count' => $item->count
      ];
    });

    return $statusCounts;
  }

  public function lastestOrder()
  {
    $orders = Order::select('id', 'user_id', 'status', 'is_paid', 'payment_method_id', 'status', 'order_code', 'name', 'email', 'phone', 'created_at')->with([
      'user' => function ($query) {
        $query->select('id', 'name');
      },
      'payment_method' => function ($query) {
        $query->select('id', 'name');
      }
    ])->latest()->limit(5)->get();

    return $orders;
  }
  public function index()
  {

    $count['user'] = User::where([['active', true], ['Role', false]])->count();
    $count['post'] = Post::count();
    $count['product'] = Product::whereHas('variants', function (Builder $query) {
      $query->where('stock_quantity', '>', 0);
    })->count();
    $count['order'] = Order::where('status', OrderStatusEnum::COMPLETED)->count();
    $data = $this->dashboardData();
    $orderStatuses = $this->orderGroupByStatus();
    $orders = $this->lastestOrder();
    return view('admin.index')->with(['count' => $count, 'data' => $data, 'orderStatuses' => $orderStatuses, 'orders' => $orders]);
  }
}
