<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Tag;
use Illuminate\Http\Request;

class ClientProductController extends Controller
{

    public function productsIndex()
    {
        $products = Product::all();
        return view('Client.pages.product', compact('products'));
    }
    // /////////////////////////////////////////////////////////////////
    public function showAllProducts(Request $request, $category_id = null)
    {
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $query = Product::query();

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        // Lọc theo khoảng giá nếu có


        $products = $query->get();


        $tags = Tag::withCount('products')->get();
        $brands = Brands::withCount('products')->get();
        $categories = Category::where('status', 1)->get();

        return view('Client.pages.all-product', compact('products', 'categories', 'minPrice', 'maxPrice', 'tags', 'brands'));
    }



    // 

    // public function filterByPrice(Request $request)
    // {
    //     // Lấy tất cả khoảng giá được chọn
    //     $priceRanges = $request->input('priceRange', []);

    //     // Khởi tạo query để lọc sản phẩm
    //     $query = Product::query();

    //     // Nếu có khoảng giá được chọn
    //     if (!empty($priceRanges)) {
    //         foreach ($priceRanges as $range) {
    //             $rangeArray = explode('-', $range);

    //             // Kiểm tra nếu giá trị có dấu "+" tức là giá trị trên 1 triệu
    //             if (count($rangeArray) == 2) {
    //                 $min = $rangeArray[0];
    //                 $max = $rangeArray[1];
    //                 $query->orWhereBetween('price', [$min, $max]);
    //             } elseif (count($rangeArray) == 1) {
    //                 // Trường hợp trên 1 triệu
    //                 $min = $rangeArray[0];
    //                 $query->orWhere('price', '>', $min);
    //             }
    //         }
    //     }

    //     // Lọc các sản phẩm
    //     $products = $query->get();

    //     // Nếu không có sản phẩm nào phù hợp
    //     if ($products->isEmpty()) {
    //         return view('Client.pages.all-product', compact('products', 'categories', 'minPrice', 'maxPrice', 'tags', 'brands'));

    //     }

    //     // Lấy các dữ liệu liên quan
    //     $minPriceRange = $products->min('price');
    //     $maxPriceRange = $products->max('price');
    //     $tags = Tag::withCount('products')->get();
    //     $brands = Brands::withCount('products')->get();
    //     $categories = Category::where('status', 1)->get();

    //     // Trả về view tất cả sản phẩm với sản phẩm đã lọc
    //     return view('Client.pages.all-product', compact('products', 'categories', 'minPriceRange', 'maxPriceRange', 'tags', 'brands'));
    // }
    public function filterByPrice(Request $request)
    {
        // Lấy tất cả khoảng giá được chọn
        $priceRanges = $request->input('priceRange', []);

        // Khởi tạo query để lọc sản phẩm
        $query = Product::query();

        // Nếu có khoảng giá được chọn
        if (!empty($priceRanges)) {
            foreach ($priceRanges as $range) {
                $rangeArray = explode('-', $range);

                // Kiểm tra nếu giá trị có dấu "+" tức là giá trị trên 1 triệu
                if (count($rangeArray) == 2) {
                    $min = $rangeArray[0];
                    $max = $rangeArray[1];
                    $query->orWhereBetween('price', [$min, $max]);
                } elseif (count($rangeArray) == 1) {
                    // Trường hợp trên 1 triệu
                    $min = $rangeArray[0];
                    $query->orWhere('price', '>', $min);
                }
            }
        }

        // Lọc các sản phẩm
        $products = $query->get();

        // Nếu không có sản phẩm nào phù hợp
        if ($products->isEmpty()) {
            // Trả về view với thông báo lỗi
            session()->flash('error', 'Không có sản phẩm phù hợp với khoảng giá đã chọn.');
            return redirect()->route('all-products'); // Hoặc bạn có thể trả về view hiện tại
        }

        // Lấy các dữ liệu liên quan
        $minPriceRange = $products->min('price');
        $maxPriceRange = $products->max('price');
        $tags = Tag::withCount('products')->get();
        $brands = Brands::withCount('products')->get();
        $categories = Category::where('status', 1)->get();

        // Trả về view tất cả sản phẩm với sản phẩm đã lọc
        return view('Client.pages.all-product', compact('products', 'categories', 'minPriceRange', 'maxPriceRange', 'tags', 'brands'));
    }



    // /////////////////////////////////////////////////////////////////

    public function showProduct(string $slug)
    {
        $product = Product::with(['variants.variantType', 'variants.variantValue', 'category', 'brand', 'tags', 'galleries'])->where('slug', $slug)->where('status', 1)->first();
        // // dd($product->variants);
        // dd($product);
        $variantTypes = $product->variants->groupBy('variantType.name');
        $comments = Comment::with(['user'])->where('product_id', $product->id)->where('status', 1)->get();
        // dd($productVariant);
        $productRelated = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->where('status', 1)->get();
        return view(
            'Client.pages.product-detail',
            compact('product', 'variantTypes', 'comments', 'productRelated')
        );
    }
}
