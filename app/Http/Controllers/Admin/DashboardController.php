<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
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
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function dashboardData()
  {
      $carbon = new Carbon('first day of this month');
      $count_products = 0;
      $total_revenue = 0;
      $total_profit = 0;
  
      $data = [
          'labels' => [],
          'revenues' => [],
          'profits' => [], // Thêm trường profits vào đây
          'weekly_revenues' => [],
          'monthly_revenues' => [],
          'yearly_revenues' => [],
          'count_products' => 0,
          'total_revenue' => 0,
          'total_profit' => 0,
          'count_orders' => 0,
          'producer' => [],
      ];
  
      // Doanh thu và lợi nhuận theo ngày
      for ($i = 0; $i < $carbon->daysInMonth; $i++) {
          $date = $carbon->copy()->addDay($i)->format('d/m/Y');
          $data['labels'][] = $date;
  
          $order_details = OrderDetail::withTrashed()->select('id', 'order_id', 'product_detail_id', 'quantity', 'price', 'created_at')
              ->whereDate('created_at', $carbon->copy()->addDay($i)->format('Y-m-d'))
              ->whereHas('order', function (Builder $query) {
                  $query->withTrashed()->where('status', '=', OrderStatusEnum::COMPLETED);
              })
              ->with([
                  'order' => function ($query) {
                      $query->withTrashed()->select('id', 'order_code', 'discount');
                  },
                  'variants' => function ($query) {
                      $query->withTrashed()->select('id', 'purchase_price', 'promotion_price');
                  },
              ])
              ->get();
  
          $revenue = 0;
          $profit = 0;
  
          foreach ($order_details as $order_detail) {
              $revenue += $order_detail->price * $order_detail->quantity - $order_detail->order->discount;
              $profit += ($order_detail->quantity * ($order_detail->price - $order_detail->variants->purchase_price)) - $order_detail->order->discount;
              $count_products += $order_detail->quantity;
          }
  
          $data['revenues'][] = $revenue;
          $data['profits'][] = $profit; // Lưu lợi nhuận vào mảng profits
          $total_revenue += $revenue;
          $total_profit += $profit;
      }
  
      // Doanh thu và lợi nhuận theo tuần
      foreach ($data['labels'] as $index => $label) {
          $week = $carbon->copy()->addDay($index)->weekOfYear;
          if (!isset($data['weekly_revenues'][$week])) {
              $data['weekly_revenues'][$week] = 0;
          }
          $data['weekly_revenues'][$week] += $data['revenues'][$index];
      }
  
      // Doanh thu theo tháng
      for ($month = 1; $month <= 12; $month++) {
          $order_details = OrderDetail::whereHas('order', function ($query) use ($month, $carbon) {
              $query->where('status', '=', OrderStatusEnum::COMPLETED)
                  ->whereYear('created_at', $carbon->year)
                  ->whereMonth('created_at', $month);
          })
          ->with('order') // Eager load the 'order' relationship
          ->get();
  
          $revenue = 0;
          $profit = 0;
  
          foreach ($order_details as $order_detail) {
              $revenue += $order_detail->price * $order_detail->quantity - $order_detail->order->discount;
              $profit += ($order_detail->quantity * ($order_detail->price - $order_detail->variants->purchase_price)) - $order_detail->order->discount;
          }
  
          $data['monthly_revenues'][$month] = $revenue;
          $data['monthly_profits'][$month] = $profit; // Thêm lợi nhuận vào mảng monthly_profits
      }
  
      // Doanh thu và lợi nhuận theo năm
      for ($year = $carbon->year - 4; $year <= $carbon->year; $year++) {
          $order_details = OrderDetail::whereHas('order', function ($query) use ($year) {
              $query->where('status', '=', OrderStatusEnum::COMPLETED)
                  ->whereYear('created_at', $year);
          })
          ->with('order') // Eager load the 'order' relationship
          ->get();
  
          $revenue = 0;
          $profit = 0;
  
          foreach ($order_details as $order_detail) {
              $revenue += $order_detail->price * $order_detail->quantity - $order_detail->order->discount;
              $profit += ($order_detail->quantity * ($order_detail->price - $order_detail->variants->purchase_price)) - $order_detail->order->discount;
          }
  
          $data['yearly_revenues'][$year] = $revenue;
          $data['yearly_profits'][$year] = $profit; // Thêm lợi nhuận vào mảng yearly_profits
      }
  
      // Tổng quan
      $data['count_products'] = $count_products;
      $data['total_revenue'] = $total_revenue;
      $data['total_profit'] = $total_profit;
      $data['count_orders'] = Order::where('status', '=', OrderStatusEnum::COMPLETED)
          ->whereYear('created_at', $carbon->year)
          ->whereMonth('created_at', $carbon->month)->count();
  
      // Nhà sản xuất
      $producers = Producer::select('name')->has('products')->get();
      foreach ($producers as $producer) {
          $data['producer'][$producer->name] = [
              'quantity' => 0,
              'revenue' => 0,
              'profit' => 0,
          ];
      }
  
      foreach ($order_details as $order_detail) {
          $producer_name = $order_detail->variants->product->producer->name;
          $data['producer'][$producer_name]['quantity'] += $order_detail->quantity;
          $data['producer'][$producer_name]['revenue'] += $order_detail->quantity * $order_detail->price;
          $data['producer'][$producer_name]['profit'] += $order_detail->quantity * ($order_detail->price - $order_detail->variants->purchase_price);
      }
  
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