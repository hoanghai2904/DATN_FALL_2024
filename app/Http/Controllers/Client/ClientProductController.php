<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class ClientProductController extends Controller
{

    public function productsIndex(){
        $products = Product::all();
        return view('Client.pages.product', compact('products'));
    }
    public function showProduct(string $slug )
    {
        $product = Product::with(['variants.variantType','variants.variantValue','category','brand','tags','galleries']) ->where('slug', $slug)->where('status', 1)->first();
        // // dd($product->variants);
        // dd($product);
        $variantTypes = $product->variants->groupBy('variantType.name');
        $comments = Comment::with(['user'])->where('product_id',$product->id)->where('status',1)->get();
        // dd($productVariant);
        $productRelated = Product::where('category_id',$product->category_id)->where('id','!=',$product->id)->where('status', 1)->get();
        return view('Client.pages.product-detail'
        ,compact('product','variantTypes','comments','productRelated')
    );
    }
}
