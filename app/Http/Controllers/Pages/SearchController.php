<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Product;
use App\Models\Advertise;
use App\Models\Post;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if($request->has('search_key') && $request->search_key != null) {
            $advertises = Advertise::where([
              ['start_date', '<=', date('Y-m-d')],
              ['end_date', '>=', date('Y-m-d')],
              ['at_home_page', '=', false]
            ])->latest()->limit(5)->get(['product_id', 'title', 'image']);

            $products = Product::select('id','name', 'image', 'rate')
            ->where('name', 'LIKE', '%' . $request->search_key . '%')
            ->whereHas('product_detail', function (Builder $query) {
                $query->where('quantity', '>', 0);
            })

    }
}
