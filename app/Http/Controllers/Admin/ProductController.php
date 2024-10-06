<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Product;
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
        return view('admin.products.create',compact(
            'categories',
            'brands'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $productValidate = $request->validate([
            'thumbnail' => ['image', 'required', 'mimes:jpeg,png,jpg,svg,webp', 'max:2048'],
            'name' => ['required'],
            'category_id' => ['required','array'],
            // 'categories.*' => 'exists:categories,id',
            // 'brands' => ['required','array'],
            // 'brands.*' => 'exists:brands,id',
            'qty' => ['required'],
            'description' => ['required', 'max:500'],
            'content' => ['required'],
            'price' => ['required'],
            // 'product_type' => ['required'],
            'status' => ['required'],
        ]);
        // $product = $request->validate([
        //     'thumbnail' => ['image', 'required', 'mimes:jpeg,png,jpg,svg,webp', 'max:2048'],
        //     'name' => ['required'],
        //     'category_id' => ['required'],
        //     'brand_id' => ['required'],
        //     'qty' => ['required'],
        //     'description' => ['required', 'max:500'],
        //     'content' => ['required'],
        //     'price' => ['required'],
        //     'product_type' => ['required'],
        //     'status' => ['required'],
        // ]);
        // $productValidate['slug'] = slug($request->name);
        // $productValidate['sku'] = generateSKU();
        $path = null;
        if($request->hasFile('thumbnail')){
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
            'description'=> $productValidate['description'],
            'content'=> $productValidate['content'],
            'price'=> $productValidate['price'],
            'price_sale'=> $price_sale,
            'product_type'=> 1,
            'qty' => $productValidate['qty'], // Thêm qty
            'status' => $productValidate['status'], // Thêm status
            // 'category_id'=>1,
            'brand_id'=>1   
        ]);


        $product->categories()->sync($productValidate['categories']);
        // $product->brands()->sync($productValidate['brands']);
        // dd($product->categories()->sync($productValidate['categories']));

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
