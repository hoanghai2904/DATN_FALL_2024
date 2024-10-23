<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Product_;
use App\Models\admin\ProductVariant_;
use App\Models\admin\Tag;
use App\Models\admin\VariantType;
use App\Models\admin\VariantValue;
use App\Models\Brands;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController_ extends Controller
{
    public function index(Request $request)
    {
        $query = Product_::query();
        $categories = Category::all();
        $brands = Brands::all();

        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        if ($request->has('brands') && !empty($request->brands)) {
            $query->where('brand_id', $request->brands);
        }

        // if ($request->has('search') && !empty($request->search)) {
        //     $query->where('name', 'like', '%' . $request->search . '%');
        // }
        $products = $query->paginate(8);

        // dd($products);
        return view('admin.products_.index', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brands::all();
        $tags = Tag::all();
        $variantTypes = VariantType::all();

        // dd($variants);

        return view('admin.products_.create', compact(
            'categories',
            'brands',
            'variantTypes',
            'tags',
        ));
    }

    public function getVariantValue(Request $request)
    {
        // dd($request->id);
        $variantValue = VariantValue::where('variant_type_id', $request->id)->get();
        return $variantValue;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Xác thực dữ liệu nếu cần
        $productValidate = $request->validate([
            'thumbnail' => ['image', 'nullable', 'mimes:jpeg,png,jpg,svg,webp', 'max:2048'],
            'name' => ['nullable'],
            'categories' => ['nullable'],
            'brands' => ['nullable'],
            'sku' => ['nullable', 'unique:products'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'price_sale' => ['nullable', 'numeric', 'min:0'],
            'qty' => ['nullable'],
            'description' => ['nullable', 'max:500'],
            'content' => ['nullable'],
            'status' => ['nullable'],
            'quantities.*' => 'required|integer|min:0', // Xác thực số lượng
            'prices.*' => 'required|numeric|min:0', // Xác thực giá
            'tags' => ['nullable', 'array'],
        ]);

        $path = null;
        if ($request->hasFile('thumbnail')) {
            $rename = slug($request->name);
            $image = $request->file('thumbnail');
            $newImage = $rename . '_' . time() . '_' . $image->getClientOriginalExtension();
            $path = $image->storeAs('uploads/products', $newImage, 'public');
        }
        $price_sale = $request->has('price_sale') ? $request->price_sale : null;

        $product = Product_::create([
            'name' => $productValidate['name'],
            'slug' => slug($productValidate['name']),
            'sku' => $productValidate['sku'],
            'thumbnail' => $path,
            'description' => $productValidate['description'],
            'content' => $productValidate['content'],
            'price' => $productValidate['price'],
            'price_sale' => $price_sale,
            'qty' => $productValidate['qty'], // Thêm qty
            'status' => $productValidate['status'], // Thêm status
            'category_id' => $productValidate['categories'],
            'brand_id' => $productValidate['brands'],
        ]);
        $variant_types = $request->input('variant_types');
        $variant_values = $request->input('variant_values');
        $quantities = $request->input('quantities');
        $prices = $request->input('prices');

        $variants = [];

        // Xử lý vòng lặp để lấy đúng thông tin
        foreach ($variant_types as $typeIndex => $variant_type_id) {
            foreach ($variant_values as $valueIndex => $variant_value_id) {
                // Tính chỉ số tương ứng cho số lượng và giá
                $qtyIndex = $typeIndex * count($variant_values) + $valueIndex;
                $priceIndex = $typeIndex * count($variant_values) + $valueIndex;

                // Kiểm tra xem chỉ số tồn tại
                if (isset($quantities[$qtyIndex]) && isset($prices[$qtyIndex])) {
                    $qty = $quantities[$qtyIndex];
                    $price = $prices[$qtyIndex];

                    $variants[] = [
                        'product_id' => $product->id,
                        'variant_type_id' => $variant_type_id,
                        'variant_value_id' => $variant_value_id,
                        'qty' => $qty,
                        'price' => $price,
                    ];
                } else {
                    // Log warning nếu không có số lượng hoặc giá
                    \Log::warning("Chỉ số không hợp lệ: qtyIndex = $qtyIndex, priceIndex = $priceIndex");
                }
            }
        }

        // Lưu vào DB
        foreach ($variants as $variant) {
            // Lưu từng variant vào DB
            ProductVariant_::create($variant);
        }

        return 123;
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        // Truy vấn sản phẩm theo ID
        $product = Product_::with(['variants.variantType', 'variants.variantValue'])->findOrFail($id);
        // dd($product);
        return view('admin.products_.edit', compact('product'));
    }
    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
