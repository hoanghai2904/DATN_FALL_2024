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
  public function edit(Request $request)
  {
    if ($request->start_end_date != null) {
      $dates = explode(' - ', $request->start_end_date);
      
      // Đảm bảo ngày được xử lý chính xác theo định dạng 'd/m/Y'
      $start_date = Carbon::createFromFormat('d/m/Y', $dates[0])->startOfDay()->format('Y-m-d');
      $end_date = Carbon::createFromFormat('d/m/Y', $dates[1])->endOfDay()->format('Y-m-d');
  
      // Kiểm tra lại giá trị ngày tháng
      // dd($start_date, $end_date);  // Đảm bảo giá trị start_date và end_date đúng
  
      $carbon = Carbon::createFromFormat('Y-m-d', $start_date);
      $days_in_range = $carbon->diffInDays(Carbon::createFromFormat('Y-m-d', $end_date));
  
      // Khởi tạo các giá trị ban đầu
      $count_products = 0;
      $total_revenue = 0;
      $total_profit = 0;
  
      // Sửa lại vòng lặp cho đúng trong trường hợp chỉ có 1 ngày
      for ($i = 0; $i <= $days_in_range; $i++) {
          $date = $carbon->copy()->addDays($i)->format('Y-m-d');
          $data['labels'][] = $date;
  
          // Lọc đơn hàng trong khoảng ngày đã chọn
          $order_details = OrderDetail::select('product_detail_id', 'quantity', 'price')
              ->whereDate('created_at', $carbon->copy()->addDays($i)->format('Y-m-d'))
              ->whereHas('order', function (Builder $query) use ($start_date, $end_date) {
                  $query->where('status', '=', OrderStatusEnum::COMPLETED)
                      ->whereBetween('created_at', [$start_date, $end_date]);
              })
              ->with([
                  'variants' => function ($query) {
                      $query->select('id', 'purchase_price');
                  }
              ])
              ->get();
  
          // Tính toán doanh thu và lợi nhuận
          $revenue = 0;
          $profit = 0;
  
          foreach ($order_details as $order_detail) {
              $revenue += $order_detail->price * $order_detail->quantity;
              $profit += $order_detail->quantity * ($order_detail->price - $order_detail->variants->purchase_price);
              $count_products += $order_detail->quantity;
          }
  
          // Cộng dồn doanh thu và lợi nhuận
          $total_revenue += $revenue;
          $total_profit += $profit;
          $data['revenues'][] = $revenue;
      }
  
      // Lưu trữ các thông tin tổng kết
      $data['count_products'] = $count_products;
      $data['total_revenue'] = $total_revenue;
      $data['total_profit'] = $total_profit;
  
      // Đếm số đơn hàng hoàn thành trong khoảng thời gian
      $data['count_orders'] = Order::where('status', '=', OrderStatusEnum::COMPLETED)
          ->whereBetween('created_at', [$start_date, $end_date])
          ->count();
  
      // Lấy chi tiết đơn hàng
      $order_details = OrderDetail::select('id', 'order_id', 'product_detail_id', 'quantity', 'price', 'created_at')
          ->whereBetween('created_at', [$start_date, $end_date])
          ->whereHas('order', function (Builder $query) {
              $query->where('status', '=', OrderStatusEnum::COMPLETED);
          })
          ->with([
            'order' => function ($query) {
              $query->select('id', 'order_code', 'discount');
            },
            'variants' => function ($query) {
              $query->select('id', 'product_id', 'attributes','sku' ,'purchase_price')->with([
                'product' => function ($query) {
                  $query->select('id', 'producer_id', 'name', 'sku_code')->with([
                    'producer' => function ($query) {
                      $query->select('id', 'name');
                    }
                  ]);
                }
              ]);
            }
          ])->latest()->get();
  
      // Lưu chi tiết đơn hàng vào mảng dữ liệu
      $data['order_details'] = $order_details;
  
      // Lấy thông tin nhà sản xuất
      $producers = Producer::select('name')->has('products')->get();
  
      foreach ($producers as $producer) {
          $data['producer'][$producer->name]['quantity'] = 0;
          $data['producer'][$producer->name]['revenue'] = 0;
          $data['producer'][$producer->name]['profit'] = 0;
      }
  
      // Tính tổng số lượng, doanh thu và lợi nhuận theo nhà sản xuất
      foreach ($order_details as $order_detail) {
        $producerName = $order_detail->variants->product->producer->name ?? 'Không thấy danh mục';
    
        $data['producer'][$producerName]['quantity'] = ($data['producer'][$producerName]['quantity'] ?? 0) + $order_detail->quantity;
        $data['producer'][$producerName]['revenue'] = ($data['producer'][$producerName]['revenue'] ?? 0) + $order_detail->quantity * $order_detail->price;
        $data['producer'][$producerName]['profit'] = ($data['producer'][$producerName]['profit'] ?? 0) + $order_detail->quantity * ($order_detail->price - ($order_detail->variants->purchase_price ?? 0));
      }
  
      // Cập nhật tiêu đề cho biểu đồ và danh sách sản phẩm
      $data['text']['title1'] = 'Biểu Đồ Kinh Doanh Thu : ' . $start_date . ' - ' . $end_date;
      $data['text']['title2'] = 'Danh Sách Sản Phẩm Xuất Kho : ' . $start_date . ' - ' . $end_date;
      $data['text']['revenue'] = 'DOANH THU';
      $data['text']['profit'] = 'LỢI NHUẬN';
  }
    return response()->json($data, 200);
  }
}
