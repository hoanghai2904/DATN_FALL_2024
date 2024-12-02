<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Producer;
use App\Models\Promotion;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Models\OrderDetail;
use App\Models\Order;
use DB;
use Illuminate\Support\Facades\Log;

class WarehouseController extends Controller
{
    public function index(){
      $product_details = DB::table('product_details')
            ->join('products', 'product_details.product_id', '=', 'products.id')
            ->leftJoin('order_details', 'product_details.id', '=', 'order_details.product_detail_id')
            ->leftJoin('orders', function ($query) {
                $query->on('order_details.order_id', '=', 'orders.id')
                    ->where('orders.status', OrderStatusEnum::DELIVERED);
            })
            ->select(
                'products.name',
                'products.image',
                'products.sku_code',
                'product_details.id',
                'product_details.quantity',
                'product_details.size',
                'product_details.product_id',
                'product_details.color',
                'product_details.created_at',
                DB::raw('SUM(CASE WHEN orders.status = ' . OrderStatusEnum::DELIVERED . ' THEN order_details.quantity ELSE 0 END) as orderDetailQuantity'),
                DB::raw('product_details.quantity - SUM(CASE WHEN orders.status = ' . OrderStatusEnum::DELIVERED . ' THEN order_details.quantity ELSE 0 END) AS conlai'),
                'order_details.product_detail_id',
                'orders.status'
            )
            ->groupBy(
                'order_details.product_detail_id',
                'product_details.size',
                'orders.status',
                'products.name',
                'products.image',
                'products.sku_code',
                'product_details.id',
                'product_details.quantity',
                'product_details.product_id',
                'product_details.color',
                'product_details.created_at'
            )
            ->get();
        
        return view('admin.warehouse.index')->with('product_details', $product_details);

    }

    public function orderDetails(Request $request){
        $product_details = DB::table('product_details')
            ->join('products', 'product_details.product_id', '=', 'products.id')
            ->join('order_details', 'product_details.id', '=', 'order_details.product_detail_id')
            ->join('orders', function ($query) {
                $query->on('order_details.order_id', '=', 'orders.id')
                    ->where('orders.status', OrderStatusEnum::DELIVERED);
            })
            ->select(
                'products.name',
                'products.image',
                'products.sku_code',
                'product_details.id',
                'product_details.quantity',
                'product_details.product_id',
                'product_details.color',
                'order_details.created_at',
                DB::raw('SUM(order_details.quantity) as orderDetailQuantity'),
                DB::raw('product_details.quantity - SUM(order_details.quantity) AS conlai'),
                'order_details.product_detail_id'
            )
            ->groupBy(
                'order_details.product_detail_id',
                'products.name',
                'products.image',
                'products.sku_code',
                'product_details.id',
                'product_details.quantity',
                'product_details.product_id',
                'product_details.color',
                'order_details.created_at'
            );

        if ($request['date_to']) {
            $product_details->whereDate('order_details.created_at', '>=', date($request['date_to']));
        }

        if ($request['date_from']) {
            $product_details->whereDate('order_details.created_at', '<=', date($request['date_from']));
        }
                                   
        return view('admin.warehouse.orderDetail')->with('product_details', $product_details);
    }
}
