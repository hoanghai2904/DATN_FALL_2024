<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Product;
use App\Models\Producer;
use App\Models\ProductDetail;
use App\Models\Advertise;
use App\Models\Post;

class HomePage extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  // public function __invoke()
  // {
  //  $products = Product::select('id', 'name', 'image', 'rate')
  //   ->whereHas('product_detail', function (Builder $query) {
  //       $query->where('quantity', '>', 0);
  //   })
  //   ->with(['product_detail' => function($query) {
  //       $query->select('id', 'product_id', 'quantity', 'sale_price', 'promotion_price', 'promotion_start_date', 'promotion_end_date')
  //             ->where('quantity', '>', 0)
  //             ->orderBy('sale_price', 'ASC');
  //   }])
  //   ->latest()
  //   ->paginate(12);

  //   $favorite_products = Product::select('id','name', 'image', 'rate')
  //   ->whereHas('product_detail', function (Builder $query) {
  //       $query->where('quantity', '>', 0);
  //   })
  //   ->with(['product_detail' => function($query) {
  //     $query->select('id', 'product_id', 'quantity', 'sale_price', 'promotion_price', 'promotion_start_date', 'promotion_end_date')->where('quantity', '>', 0)->orderBy('sale_price', 'ASC');
  //   }])->latest()->orderBy('rate', 'DESC')->limit(10)->get();

  //   $producers = Producer::select('id', 'name')->get();

  //   $advertises = Advertise::where([
  //     ['start_date', '<=', date('Y-m-d')],
  //     ['end_date', '>=', date('Y-m-d')],
  //     ['at_home_page', '=', true]
  //   ])->latest()->limit(5)->get(['product_id', 'title', 'image']);


  //   $posts = Post::select('id', 'title', 'image', 'created_at')->latest()->limit(4)->get();
  //     dd($favorite_products);
  //   return view('pages.home')->with('data',['products' => $products, 'favorite_products'=>$favorite_products, 'posts'=> $posts, 'advertises' => $advertises, 'producers' => $producers]);
  // }


  public function __invoke()
  {
      // Lấy danh sách sản phẩm
      $baseQuery = Product::select('id', 'name', 'image', 'rate')
          ->whereHas('variants', function (Builder $query) {
              $query->where('stock_quantity', '>', 0);
          })
          ->with(['variants' => function ($query) {
              $query->select('id', 'product_id', 'stock_quantity', 'price', 'promotion_price', 'promotion_start_date', 'promotion_end_date')
                  ->where('stock_quantity', '>', 0)
                  ->orderBy('price', 'ASC');
          }]);
  
      $products = (clone $baseQuery)->latest()->paginate(12);
  
      $favorite_products = (clone $baseQuery)
          ->orderBy('rate', 'DESC')
          ->limit(10)
          ->get();
  
      // Lấy danh sách nhà sản xuất
      $producers = Producer::select('id', 'name')->get();
  
      // Lấy danh sách quảng cáo
      $advertises = Advertise::where([
          ['start_date', '<=', date('Y-m-d')],
          ['end_date', '>=', date('Y-m-d')],
          ['at_home_page', '=', true]
      ])->latest()->limit(5)->get(['product_id', 'title', 'image']);
  
      // Lấy bài viết mới nhất
      $posts = Post::select('id', 'title', 'image', 'created_at')->latest()->limit(4)->get();
  
      return view('pages.home', compact('products', 'favorite_products', 'producers', 'advertises', 'posts'));
  }
  
}
