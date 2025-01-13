<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Producer;

class StatisticController extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  // public function index()
  // {
  //   $carbon = new Carbon('first day of this month');

  //   $count_products = 0;
  //   $total_revenue = 0;
  //   $total_profit = 0;

  //   for($i = 0; $i < $carbon->daysInMonth; $i++) {

  //     $date = $carbon->copy()->addDay($i)->format('d/m/Y');

  //     $data['labels'][] = $date;

  //     $order_details = OrderDetail::select('product_detail_id', 'quantity', 'price')
  //       ->whereDate('created_at', $carbon->copy()->addDay($i)->format('Y-m-d'))
  //       ->whereHas('order', function (Builder $query) {
  //         $query->where('status', '=', OrderStatusEnum::COMPLETED);
  //       })->with([
  //         'product_detail' => function($query) {
  //           $query->select('id', 'import_price');
  //         }
  //       ])->get();

  //     $revenue = 0;
  //     $profit = 0;

  //     foreach ($order_details as $order_detail) {
  //       $revenue = $revenue + $order_detail->price * $order_detail->quantity;
  //       $profit = $profit + $order_detail->quantity * ($order_detail->price - $order_detail->product_detail->import_price);
  //       $count_products = $count_products + $order_detail->quantity;
  //     }

  //     $total_revenue = $total_revenue + $revenue;
  //     $total_profit = $total_profit + $profit;
  //     $data['revenues'][] = $revenue;
  //   }

  //   $data['count_products'] = $count_products;
  //   $data['total_revenue'] = $total_revenue;
  //   $data['total_profit'] = $total_profit;
  //   $data['count_orders'] = Order::where('status', '=', OrderStatusEnum::COMPLETED)
  //     ->whereYear('created_at', $carbon->year)
  //     ->whereMonth('created_at', $carbon->month)->count();

  //   $order_details = OrderDetail::select('id', 'order_id', 'product_detail_id', 'quantity', 'price', 'created_at')->whereYear('created_at', $carbon->year)->whereMonth('created_at', $carbon->month)
  //     ->whereHas('order', function (Builder $query) {
  //       $query->where('status', '=', OrderStatusEnum::COMPLETED);
  //     })->with([
  //       'order' => function($query) {
  //         $query->select('id', 'order_code');
  //       },
  //       'product_detail' =>function($query) {
  //         $query->select('id', 'product_id', 'color', 'import_price')->with([
  //           'product' => function($query) {
  //             $query->select('id', 'producer_id', 'name', 'sku_code')->with([
  //               'producer' => function($query) {
  //                 $query->select('id', 'name');
  //               }
  //             ]);
  //           }
  //         ]);
  //       }
  //     ])->latest()->get();

  //   $data['order_details'] = $order_details;

  //   $producers = Producer::select('name')->has('products')->get();

  //   foreach ($producers as $producer) {
  //     $data['producer'][$producer->name]['quantity'] = 0;
  //     $data['producer'][$producer->name]['revenue'] = 0;
  //     $data['producer'][$producer->name]['profit'] = 0;
  //   }

  //   foreach ($order_details as $order_detail) {
  //     $data['producer'][$order_detail->product_detail->product->producer->name]['quantity'] = $data['producer'][$order_detail->product_detail->product->producer->name]['quantity'] + $order_detail->quantity;

  //     $data['producer'][$order_detail->product_detail->product->producer->name]['revenue'] = $data['producer'][$order_detail->product_detail->product->producer->name]['revenue'] + $order_detail->quantity * $order_detail->price;

  //     $data['producer'][$order_detail->product_detail->product->producer->name]['profit'] = $data['producer'][$order_detail->product_detail->product->producer->name]['profit'] + $order_detail->quantity * ($order_detail->price - $order_detail->product_detail->import_price);
  //   }

  //   return view('admin.index')->with('data', $data);
  // }

  public function edit(Request $request)
  {
    // Lấy giá trị từ request
$day = $request->input('day');
$month = $request->input('month'); // Lấy tháng từ request
$year = $request->input('year');

// Thiết lập ngày mặc định
$carbon = new Carbon('first day of this month');
if ($year) {
    $carbon->year($year);
}
if ($month) {
    $carbon->month($month); // Dùng giá trị tháng từ request
}

$count_products = 0;
$total_revenue = 0;
$total_profit = 0;

$data = [
    'labels' => [],
    'revenues' => [],
    'profits' => [],
    'weekly_revenues' => [],
    'monthly_revenues' => [],
    'monthly_profits' => [],
    'yearly_revenues' => [],
    'yearly_profits' => [],
    'count_products' => 0,
    'total_revenue' => 0,
    'total_profit' => 0,
    'count_orders' => 0,
    'producer' => [],
];

// Doanh thu và lợi nhuận theo ngày
$daysInMonth = $day ? 1 : $carbon->daysInMonth;
for ($i = 0; $i < $daysInMonth; $i++) {
    $currentDay = $day ? $carbon->copy()->day($day) : $carbon->copy()->addDay($i);
    $date = $currentDay->format('d/m/Y');
    $data['labels'][] = $date;

    $order_details = OrderDetail::whereDate('created_at', $currentDay->format('Y-m-d'))
        ->whereHas('order', function (Builder $query) {
            $query->where('status', '=', OrderStatusEnum::COMPLETED);
        })
        ->with(['order:id,order_code,discount', 'variants:id,purchase_price'])
        ->get();

    $revenue = 0;
    $profit = 0;

    foreach ($order_details as $order_detail) {
        $revenue += $order_detail->price * $order_detail->quantity - $order_detail->order->discount;
        $profit += ($order_detail->quantity * ($order_detail->price - $order_detail->variants->purchase_price)) - $order_detail->order->discount;
        $count_products += $order_detail->quantity;
    }

    $data['revenues'][] = $revenue;
    $data['profits'][] = $profit;
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

// Doanh thu và lợi nhuận theo tháng (Sử dụng tháng từ request)
for ($monthLoop = 1; $monthLoop <= 12; $monthLoop++) {
    // Nếu $month có giá trị, chỉ lọc theo tháng đó
    if ($month && $month != $monthLoop) {
        continue; // Bỏ qua các tháng không phải là tháng được chọn
    }

    $order_details = OrderDetail::whereHas('order', function ($query) use ($monthLoop, $carbon) {
        $query->where('status', '=', OrderStatusEnum::COMPLETED)
            ->whereYear('created_at', $carbon->year)
            ->whereMonth('created_at', $monthLoop);
    })
    ->with('order', 'variants')
    ->get();

    $revenue = 0;
    $profit = 0;

    foreach ($order_details as $order_detail) {
        $revenue += $order_detail->price * $order_detail->quantity - $order_detail->order->discount;
        $profit += ($order_detail->quantity * ($order_detail->price - $order_detail->variants->purchase_price)) - $order_detail->order->discount;
    }

    $data['monthly_revenues'][$monthLoop] = $revenue;
    $data['monthly_profits'][$monthLoop] = $profit;
}

// Doanh thu và lợi nhuận theo năm
for ($yearLoop = $carbon->year - 4; $yearLoop <= $carbon->year; $yearLoop++) {
    $order_details = OrderDetail::whereHas('order', function ($query) use ($yearLoop) {
        $query->where('status', '=', OrderStatusEnum::COMPLETED)
            ->whereYear('created_at', $yearLoop);
    })
    ->with('order', 'variants')
    ->get();

    $revenue = 0;
    $profit = 0;

    foreach ($order_details as $order_detail) {
        $revenue += $order_detail->price * $order_detail->quantity - $order_detail->order->discount;
        $profit += ($order_detail->quantity * ($order_detail->price - $order_detail->variants->purchase_price)) - $order_detail->order->discount;
    }

    $data['yearly_revenues'][$yearLoop] = $revenue;
    $data['yearly_profits'][$yearLoop] = $profit;
}

// Tổng quan
$data['count_products'] = $count_products;
$data['total_revenue'] = $total_revenue;
$data['total_profit'] = $total_profit;
$data['count_orders'] = Order::where('status', '=', OrderStatusEnum::COMPLETED)
    ->whereYear('created_at', $carbon->year)
    ->whereMonth('created_at', $carbon->month)
    ->count();

// Nhà sản xuất
$producers = Producer::select('name')->has('products')->get();
foreach ($producers as $producer) {
    $data['producer'][$producer->name] = [
        'quantity' => 0,
        'revenue' => 0,
        'profit' => 0,
    ];
}

$order_details = OrderDetail::whereHas('order', function ($query) {
    $query->where('status', '=', OrderStatusEnum::COMPLETED);
})
->with('variants.product.producer')
->get();

foreach ($order_details as $order_detail) {
    $producer_name = $order_detail->variants->product->producer->name;
    $data['producer'][$producer_name]['quantity'] += $order_detail->quantity;
    $data['producer'][$producer_name]['revenue'] += $order_detail->quantity * $order_detail->price;
    $data['producer'][$producer_name]['profit'] += $order_detail->quantity * ($order_detail->price - $order_detail->variants->purchase_price);
}

return $data;

  }
  
  
}
