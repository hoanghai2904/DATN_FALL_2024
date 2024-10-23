<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Product;
use App\Models\admin\ProductGallery;
use App\Models\admin\ProductTypes;
use App\Models\admin\ProductVariants;
use App\Models\admin\ProductWeights;
use App\Models\admin\Tag;
use App\Models\Brands;
use App\Models\Category;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Flasher\Notyf\Prime\NotyfInterface;


use Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());

        $query = Product::query();
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
        return view('admin.products.index', compact('products', 'categories', 'brands'));
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
        $tags = Tag::all();
        // dd($types,$weights);
        return view('admin.products.create', compact(
            'categories',
            'brands',
            'types',
            'weights',
            'tags',
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
            'sku' => ['nullable', 'unique:products'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_sale' => ['nullable', 'numeric', 'min:0'],
            'qty' => ['required'],
            'description' => ['required', 'max:500'],
            'content' => ['required'],
            // 'product_type' => ['required'],
            'status' => ['required'],
            'variants' => ['array'],
            'variants.*.product_type_id' => ['nullable', 'exists:product_types,id'],
            'variants.*.product_weight_id' => ['nullable', 'exists:product_weights,id'],
            'variants.*.qty' => ['required', 'integer', 'min:0'],
            'variants.*.price_variant' => ['required', 'numeric', 'min:0'], // Validate giá biến thể
            'variants.*.image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,webp', 'max:2048'],
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

        $product = Product::create([
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

        // $product = new Product();
        // $product->name = $productValidate['name'];
        // $product->slug = slug($productValidate['name']);
        // $product->sku = $productValidate['sku'];
        // $product->thumbnail = $path;
        // $product->description = $productValidate['description'];
        // $product->content = $productValidate['content'];
        // $product->price = $productValidate['price'];
        // $product->price_sale = $price_sale;
        // $product->qty = $productValidate['qty']; // Adding qty
        // $product->status = $productValidate['status']; // Adding status
        // $product->category_id = $productValidate['categories'];
        // $product->brand_id = $productValidate['brands'];

        // // Save the product
        // $product->save();

        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                // Lưu biến thể
                $productVariant = new ProductVariants();
                $productVariant->product_id = $product->id;
                $productVariant->product_type_id = isset($variant['product_type_id']) ? $variant['product_type_id'] : null;
                $productVariant->product_weight_id = isset($variant['product_weight_id']) ? $variant['product_weight_id'] : null;
                $productVariant->qty = $variant['qty'];
                $productVariant->price_variant = $variant['price_variant'];

                // // Xử lý hình ảnh biến thể
                // if (isset($variant['image'])) {
                //     $image = $variant['image'];
                //     $newImage = time() . '_' . $variant['product_type_id']? $variant['product_type_id'] : 0 . '_' . $variant['product_weight_id'] . '.' . $image->getClientOriginalExtension();
                //     $pathVariant = $image->storeAs('uploads/products/variants', $newImage, 'public');
                //     $productVariant->image = $pathVariant;
                // }

                $productVariant->save();
            }
        }

        if ($request->has('tags')) {
            foreach ($request->tags as $tag) {
                //attach() trong Laravel dùng để gắn một bản ghi vào bảng trung gian. Nó sẽ thêm một dòng mới vào bảng product_tag, bao gồm product_id và tag_id
                $product->tags()->attach($tag);
            }
        }

        if ($request->hasFile('galleries')) {
            $productPrefix = slug($product->name);
            $index = 1;
            foreach ($request->file('galleries') as $gallery) {
                $newImage = $productPrefix . '_' . $index . '_' . uniqid() . '.' . $gallery->getClientOriginalExtension();
                $path = $gallery->storeAs('uploads/products/galleries', $newImage, 'public');

                $productGallery = new ProductGallery();
                $productGallery->product_id = $product->id;
                $productGallery->image = $path;
                $productGallery->name = $newImage;

                $productGallery->save();
                $index++;
            }
        }

        // return '123';
        // notyf()->success('Thêm mới sản phẩm thành công.');
        return redirect()->route('admin.products.index')->with('success', 'Thêm mới sản phẩm thành công.');
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
        echo '123';
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
        $product = Product::findOrFail($id);
        $product->delete();
        return response(['status' => 'success', 'Xóa thành công!']);
    }

    public function changeStatus(Request $request)
    {
        // dd($request->id);
        $product = Product::findOrFail($request->id);
        // dd($product);
        $product->status = $request->status == 'true' ? 1 : 0;
        $product->save();

        return response(['message' => 'Cập nhật trạng thái thành công!']);
    }
}
