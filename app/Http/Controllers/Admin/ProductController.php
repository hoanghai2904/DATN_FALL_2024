<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Product;
use App\Models\admin\ProductTypes;
use App\Models\admin\ProductVariants;
use App\Models\admin\ProductWeights;
use App\Models\Brands;
use App\Models\Category;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Illuminate\Http\Request;

use Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brands::all();
        $types = ProductTypes::all();
        $weights = ProductWeights::all();
        // dd($types,$weights);
        return view('admin.products.create', compact(
            'categories',
            'brands',
            'types',
            'weights'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());

        $productValidate = $request->validate([
            'thumbnail' => ['image', 'required', 'mimes:jpeg,png,jpg,svg,webp', 'max:2048'],
            'name' => ['required'],
            'categories' => ['required'],
            'brands' => ['required'],
            'qty' => ['required'],
            'description' => ['required', 'max:500'],
            'content' => ['required'],
            'price' => ['required'],
            // 'product_type' => ['required'],
            'status' => ['required'],
            'variants' => ['array'],
            'variants.*.product_type_id' => ['nullable','exists:product_types,id'],
            'variants.*.product_weight_id' => ['nullable','exists:product_weights,id'],
            'variants.*.qty' => ['required','integer','min:0'],
            'variants.*.price_variant' => ['required','numeric','min:0'], // Validate giá biến thể
            'variants.*.image' => ['nullable','image','mimes:jpeg,png,jpg,svg,webp','max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $newImage = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('uploads/products', $newImage, 'public');
        }
        $price_sale = $request->has('price_sale') ? $request->price_sale : null;

        $product = Product::create([
            'name' => $productValidate['name'],
            'slug' => slug($request->name),
            'sku' => generateSKU(),
            'thumbnail' => $path,
            'description' => $productValidate['description'],
            'content' => $productValidate['content'],
            'price' => $productValidate['price'],
            'price_sale' => $price_sale,
            'product_type' => 1,
            'qty' => $productValidate['qty'], // Thêm qty
            'status' => $productValidate['status'], // Thêm status
            'category_id' => $productValidate['categories'],
            'brand_id' => $productValidate['brands'],
        ]);

        if($request->has('variants')){
            foreach ($request->variants as $variant) {
                // Lưu biến thể
                $productVariant = new ProductVariants();
                $productVariant->product_id = $product->id;
                $productVariant->product_type_id = $variant['product_type_id'];
                $productVariant->product_weight_id = $variant['product_weight_id'];
                $productVariant->qty = $variant['qty'];
                $productVariant->price_variant = $variant['price_variant'];
    
                // Xử lý hình ảnh biến thể
                if (isset($variant['image'])) {
                    $image = $variant['image'];
                    $newImage = time() . '_' . $variant['product_type_id'] . '_' . $variant['product_weight_id'] . '.' . $image->getClientOriginalExtension();
                    $pathVariant = $image->storeAs('uploads/products/variants', $newImage, 'public');
                    $productVariant->image = $pathVariant;
                }
    
                $productVariant->save();
            }
        }

        return '123';
        // return redirect()->route('admin.products');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
