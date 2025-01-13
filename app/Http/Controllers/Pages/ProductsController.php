<?php

namespace App\Http\Controllers\Pages;

use App\Enums\OrderStatusEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\ProductDetail;
use App\Models\Producer;
use App\Models\Product;
use App\Models\Advertise;
use App\Models\AttributeValue;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use App\Models\ProductVote;
use App\Models\Attribute;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('type') && $request->input('type') == 'promotion') {
            $query_products = Product::whereHas('variants', function (Builder $query) {
                $query->where([
                    ['stock_quantity', '>', 0],
                    ['promotion_price', '>', 0],
                    ['promotion_start_date', '<=', date('Y-m-d')],
                    ['promotion_end_date', '>=', date('Y-m-d')]
                ]);
            });
        } else {
            $query_products = Product::whereHas('variants', function (Builder $query) {
                $query->where('stock_quantity', '>', 0);
            });
        }

        $query_products->with(['variants' => function ($query) {
            $query->select('id', 'product_id', 'stock_quantity', 'price', 'promotion_price', 'promotion_start_date', 'promotion_end_date')
                ->where('stock_quantity', '>', 0)
                ->orderBy('price', 'ASC');
        }]);

        if ($request->has('name') && $request->input('name') != null) {
            $query_products->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->has('price') && $request->input('price') != null) {
            $min_price_query = ProductVariant::select('product_id', DB::raw('min(price) as min_sale_price'))
                ->where('stock_quantity', '>', 0)
                ->groupBy('product_id');

            $query_products->joinSub($min_price_query, 'min_price_query', function ($join) {
                $join->on('products.id', '=', 'min_price_query.product_id');
            })->select('id', 'name', 'image', 'rate')->orderBy('min_sale_price', $request->input('price'));
        } else {
            $query_products->select('id', 'name', 'image', 'rate')->latest();
        }

        if ($request->has('price_min') && $request->input('price_min') != null) {
            $query_products->whereHas('variants', function (Builder $query) use ($request) {
                $query->where('price', '>=', $request->input('price_min'));
            });
        }

        if ($request->has('price_max') && $request->input('price_max') != null) {
            $query_products->whereHas('variants', function (Builder $query) use ($request) {
                $query->where('price', '<=', $request->input('price_max'));
            });
        }

        if ($request->has('type') && $request->input('type') == 'vote') {
            $query_products->orderBy('rate', 'desc');
        }

        $products = $query_products->paginate(15);

        $advertises = Advertise::where([
            ['start_date', '<=', date('Y-m-d')],
            ['end_date', '>=', date('Y-m-d')],
            ['at_home_page', '=', false]
        ])->latest()->limit(5)->get(['product_id', 'title', 'image']);

        $producers = Producer::select('id', 'name')->get();

        return view('pages.products')->with(['data' => ['advertises' => $advertises, 'producers' => $producers, 'products' => $products]]);
    }

    public function getProducer(Request $request, $id)
    {
        if ($request->has('type') && $request->input('type') == 'promotion') {
            $query_products = Product::whereHas('variants', function (Builder $query) {
                $query->where([
                    ['stock_quantity', '>', 0],
                    ['promotion_price', '>', 0],
                    ['promotion_start_date', '<=', date('Y-m-d')],
                    ['promotion_end_date', '>=', date('Y-m-d')]
                ]);
            });
        } else {
            $query_products = Product::whereHas('variants', function (Builder $query) {
                $query->where('stock_quantity', '>', 0);
            });
        }

        $query_products->with(['variants' => function ($query) {
            $query->select('id', 'product_id', 'stock_quantity', 'price', 'promotion_price', 'promotion_start_date', 'promotion_end_date')
                ->where('stock_quantity', '>', 0)
                ->orderBy('price', 'ASC');
        }]);

        if ($request->has('name') && $request->input('name') != null) {
            $query_products->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->has('price') && $request->input('price') != null) {
            $min_price_query = ProductVariant::select('product_id', DB::raw('min(price) as min_sale_price'))
                ->where('quantity', '>', 0)
                ->groupBy('product_id');

            $query_products->joinSub($min_price_query, 'min_price_query', function ($join) {
                $join->on('products.id', '=', 'min_price_query.product_id');
            })->select('id', 'name', 'image', 'rate')->orderBy('min_sale_price', $request->input('price'));
        } else {
            $query_products->select('id', 'name', 'image', 'rate')->latest();
        }

        if ($request->has('price_min') && $request->input('price_min') != null) {
            $query_products->whereHas('variants', function (Builder $query) use ($request) {
                $query->where('price', '>=', $request->input('price_min'));
            });
        }

        if ($request->has('price_max') && $request->input('price_max') != null) {
            $query_products->whereHas('variants', function (Builder $query) use ($request) {
                $query->where('price', '<=', $request->input('price_max'));
            });
        }

        if ($request->has('type') && $request->input('type') == 'vote') {
            $query_products->orderBy('rate', 'desc');
        }

        $products = $query_products->where('producer_id', $id)->paginate(15);

        $advertises = Advertise::where([
            ['start_date', '<=', date('Y-m-d')],
            ['end_date', '>=', date('Y-m-d')],
            ['at_home_page', '=', false]
        ])->latest()->limit(5)->get(['product_id', 'title', 'image']);

        $producers = Producer::where('id', '<>', $id)->select('id', 'name')->get();
        $producer = Producer::select('id', 'name')->find($id);

        if (!$producer) abort(404);

        return view('pages.producer')->with(['data' => ['advertises' => $advertises, 'producers' => $producers, 'products' => $products], 'producer' => $producer]);
    }

    public function getProduct(Request $request, $id)
    {

        $advertises = Advertise::where([
            ['start_date', '<=', date('Y-m-d')],
            ['end_date', '>=', date('Y-m-d')],
            ['at_home_page', '=', false]
        ])->latest()->limit(5)->get(['product_id', 'title', 'image']);

        $product = Product::select('id', 'producer_id', 'name', 'sku_code', 'rate', 'information_details', 'product_introduction')
            ->whereHas('variants', function (Builder $query) {
                $query->where('stock_quantity', '>', 0);
            })
            ->where('id', $id)->with(['promotions' => function ($query) {
                $query->select('id', 'product_id', 'content')
                    ->where([
                        ['start_date', '<=', date('Y-m-d')],
                        ['end_date', '>=', date('Y-m-d')]
                    ])
                    ->latest();
            }])->with(['producer' => function ($query) {
                $query->select('id', 'name');
            }])->first();

        if (!$product) abort(404);

        $product_details = ProductVariant::where('product_id', $id)
            ->where('stock_quantity', '>', 0)
            ->with([
                'images' => function ($query) {
                    $query->select('id', 'product_detail_id', 'image_name');
                },
            ])
            ->get()
            ->map(function ($item) {
                // Tách sku thành các phần (ví dụ: ph23-Xanh-Đỏ)
                $colors = array_slice(explode('-', $item->sku), 1); // Tách SKU như 'ph23-Xanh-Đỏ' thành ['Xanh', 'Đỏ']
                $colors = array_map('trim', $colors);
                // Lấy danh sách thuộc tính từ bảng attributes
                $attributes = explode('-', $item->attributes); // Tách attributes như '40-41'

                // Khởi tạo một mảng để chứa các biến thể
                $variant_details = [];

                foreach ($attributes as $attribute_id) {
                    // Tra cứu thông tin thuộc tính (VD: 40 -> Màu sắc)
                    $attribute = Attribute::find($attribute_id);
                    // $attribute_values = AttributeValue::where('attribute_id', $attribute_id)->get();

                    $variant_details[] = [
                        'attribute_name' => $attribute ? $attribute->name : 'Không xác định'
                    ];
                }
                // dd( $variant_details);
                // Gán giá trị cho 'color' và 'size' dựa trên số lượng phần tử trong $variant_details
                $color = null;
                $size = null;

                if (count($variant_details) > 1) {
                    // Nếu có nhiều hơn 1 thuộc tính, gán thuộc tính đầu tiên cho color và thuộc tính thứ hai cho size
                    $color = $colors[0];
                    $size = $colors[1];
                } elseif (count($variant_details) === 1) {
                    // Nếu chỉ có 1 thuộc tính, gán thuộc tính đó cho color
                    $color = $colors[0];
                }

                // Tạo ra cấu trúc dữ liệu trả về
                return [
                    'id' => $item->id,
                    'sku' => $colors,
                    'variants' => $variant_details, // Biến thể từ attributes
                    'color' => $color,
                    'size' => $size,
                    'stock_quantity' => $item->stock_quantity,
                    'price' => $item->price,
                    'promotion_price' => $item->promotion_price,
                    'promotion_start_date' => $item->promotion_start_date,  // Lấy ngày bắt đầu khuyến mãi
                    'promotion_end_date' => $item->promotion_end_date,  // Lấy ngày kết thúc khuyến mãi
                    'product_images' => $item->images,
                ];
            })
            ->groupBy('color') // Nhóm theo màu sắc
            ->map(function ($items) {
                return [
                    'color' => $items->first()['color'], // Truy cập như một mảng
                    'details' => $items->map(function ($item) {
                        return [
                            'id' => $item['id'],
                            'size' => $item['size'],
                            'color' => $item['color'],
                            'quantity' => $item['stock_quantity'],
                            'sale_price' => $item['price'],
                            'promotion_price' => $item['promotion_price'],
                            'promotion_start_date' => $item['promotion_start_date'],
                            'promotion_end_date' => $item['promotion_end_date'],
                            'product_images' => $item['product_images'],
                            'variants' => $item['variants'],
                        ];
                    })->values(),
                ];
            })
            ->values();


        $suggest_products = Product::select('id', 'name', 'image', 'rate')
            ->whereHas('variants', function (Builder $query) {
                $query->where('stock_quantity', '>', 0);
            })
            ->where([['producer_id', $product->producer_id], ['id', '<>', $id]])
            ->with(['variants' => function ($query) {
                $query->select('id', 'product_id', 'sku', 'attributes', 'stock_quantity', 'price', 'promotion_price', 'promotion_start_date', 'promotion_end_date')->where('stock_quantity', '>', 0)->orderBy('price', 'ASC');
            }])->latest()->limit(3)->get();


        $product_votes = ProductVote::whereHas('user', function (Builder $query) {
            $query->where([['active', true], ['Role', false]]);
        })->where('product_id', $id)->with(['user' => function ($query) {
            $query->select('id', 'name', 'avatar_image');
        }])->latest()->get();
        $canComment = false;
        $user = auth()->user();
        if ($user) {
            $hasCommented = ProductVote::where('product_id', $product->id)
                ->where('user_id', $user->id)
                ->exists();

            $hasPurchased = OrderDetail::whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('status', OrderStatusEnum::COMPLETED)
                    ->where('is_paid', true)
                    ->where('is_received', true);
            })->whereHas('variants', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
                ->exists();

            // Chỉ được bình luận nếu đã mua nhưng chưa bình luận
            $canComment = $hasPurchased && !$hasCommented;
            // dd($suggest_products);
        }
        return view('pages.product')->with(['data' => ['advertises' => $advertises, 'product' => $product, 'product_details' => $product_details, 'suggest_products' => $suggest_products, 'product_votes' => $product_votes, 'canComment' => $canComment]]);
    }

    public function addVote(Request $request)
    {
        $vote = ProductVote::updateOrCreate(
            ['user_id' => $request->user_id, 'product_id' => $request->product_id],
            ['content' => $request->content, 'rate' => $request->rate]
        );
        $rate = ProductVote::where('product_id', $request->product_id)->avg('rate');

        $product = Product::where('id', $request->product_id)->first();
        $product->rate = $rate;
        $product->save();

        return back()->with(['vote_alert' => [
            'type' => 'success',
            'title' => 'Đã Gửi Đánh Giá',
            'content' => 'Cảm ơn bạn đã đóng góp về sản phẩm này. Chúng tôi luôn luôn trân trong những đóng góp của bạn.'
        ]]);
    }

    public function toggleWishlist(Request $request)
    {
        $productDetail = ProductVariant::where('id', $request->product_id)
            ->with(['product' => function ($query) {
                $query->select('id', 'name', 'image', 'sku_code');
            }])
            ->select('id', 'product_id', 'sku', 'attributes', 'stock_quantity', 'price', 'promotion_price', 'promotion_start_date', 'promotion_end_date')
            ->first();

        if (!$productDetail) {
            $data['msg'] = 'Sản phẩm không tồn tại!';
            return response()->json($data, 404);
        }

        $wishlist = session()->has('wishlist') ? session('wishlist') : collect();

        $wishlistItem = [
            'product_id' => $productDetail->product_id,
            'product_detail_id' => $productDetail->id
        ];

        if ($wishlist->contains(function ($item) use ($wishlistItem) {
            return $item['product_detail_id'] === $wishlistItem['product_detail_id'];
        })) {
            $wishlist = $wishlist->reject(function ($item) use ($wishlistItem) {
                return $item['product_detail_id'] === $wishlistItem['product_detail_id'];
            });
            session(['wishlist' => $wishlist]);
            $data['msg'] = 'Đã xóa khỏi danh sách yêu thích';
            $data['status'] = 'removed';
        } else {
            $wishlist->push($wishlistItem);
            session(['wishlist' => $wishlist]);
            $data['msg'] = 'Đã thêm vào danh sách yêu thích';
            $data['status'] = 'added';
        }

        $data['response'] = session('wishlist');

        return response()->json($data, 200);
    }

    public function showWishlist()
    {
        $advertises = Advertise::where([
            ['start_date', '<=', date('Y-m-d')],
            ['end_date', '>=', date('Y-m-d')],
            ['at_home_page', '=', false]
        ])->latest()->limit(5)->get(['product_id', 'title', 'image']);

        $wishlist = session()->has('wishlist') ? session('wishlist') : collect();

        // Retrieve product details for each wishlist item
        $wishlistItems = $wishlist->map(function ($item) {
            return ProductVariant::with(['product', 'images' => function ($query) {
                $query->select('id', 'product_detail_id', 'image_name')->limit(1);
            }])->find($item['product_detail_id']);
        });

        return view('pages.wishlist')->with(['wishlistItems' => $wishlistItems, 'advertises' => $advertises]);
    }
}
