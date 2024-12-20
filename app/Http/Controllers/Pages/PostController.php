<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Advertise;
use App\Models\Post;
use App\Models\Product;

class PostController extends Controller
{
  public function index()
  {
    $advertises = Advertise::where([
      ['start_date', '<=', date('Y-m-d')],
      ['end_date', '>=', date('Y-m-d')],
      ['at_home_page', '=', false]
    ])->latest()->limit(5)->get(['product_id', 'title', 'image']);

    $suggest_products = Product::select('id','name', 'image', 'rate')
    ->whereHas('product_details', function (Builder $query) {
        $query->where('quantity', '>', 0);
    })
    ->with(['product_detail' => function($query) {
      $query->select('id', 'product_id', 'quantity', 'sale_price', 'promotion_price', 'promotion_start_date', 'promotion_end_date')->where('quantity', '>', 0)->orderBy('sale_price', 'ASC');
    }])->latest()->limit(4)->get();

    $posts = Post::select('id', 'title', 'image', 'created_at')->latest()->paginate(11);

    return view('pages.posts')->with(['data' => ['advertises' => $advertises, 'posts' => $posts, 'suggest_products' => $suggest_products]]);
  }

  public function show(Request $request)
  {
    $advertises = Advertise::where([
      ['start_date', '<=', date('Y-m-d')],
      ['end_date', '>=', date('Y-m-d')],
      ['at_home_page', '=', false]
    ])->latest()->limit(5)->get(['product_id', 'title', 'image']);

    $suggest_products = Product::select('id','name', 'image', 'rate')
    ->whereHas('product_details', function (Builder $query) {
        $query->where('quantity', '>', 0);
    })
    ->with(['product_detail' => function($query) {
      $query->select('id', 'product_id', 'quantity', 'sale_price', 'promotion_price', 'promotion_start_date', 'promotion_end_date')->where('quantity', '>', 0)->orderBy('sale_price', 'ASC');
    }])->latest()->limit(4)->get();

    $post = Post::select('id', 'title', 'image', 'content', 'created_at')
      ->where('id', $request->id)->first();

    if(!$post) abort(404);

    $suggest_posts = Post::select('id', 'title', 'image', 'created_at')
      ->where('id', '<>', $post->id)->latest()->limit(5)->get();

    return view('pages.post')->with(['data' => ['advertises' => $advertises, 'post' => $post, 'suggest_products' => $suggest_products, 'suggest_posts' => $suggest_posts]]);
  }
}

