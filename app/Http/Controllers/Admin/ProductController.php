<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Tag;
use App\Models\VariantType;
use App\Models\VariantValue;
use App\Models\ProductGallery;
use App\Models\Brands;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
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

    public function create()
    {
        $categories = Category::all();
        $brands = Brands::all();
        $tags = Tag::all();
        $variantTypes = VariantType::all();

        // dd($variants);

        return view('admin.products.create', compact(
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
            'thumbnail' => ['image', 'required', 'mimes:jpeg,png,jpg,svg,webp', 'max:2048'],
            'name' => ['required'],
            'categories' => ['required'],
            'brands' => ['required'],
            'sku' => ['nullable', 'unique:products'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_sale' => ['nullable', 'numeric', 'min:0'],
            'qty' => ['required'],
            'description' => ['required', 'max:500'],
            'content' => ['nullable'],
            'status' => ['required'],
            'quantities.*' => 'nullable|integer|min:0', // Xác thực số lượng
            'prices.*' => 'nullable|numeric|min:0', // Xác thực giá
            'tags' => ['nullable', 'array'],
        ],
        [
            'thumbnail.image' => 'Ảnh phải là một tệp hình ảnh.',
            'thumbnail.required' => 'Ảnh đại diện không được để trống.',
            'thumbnail.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, svg, hoặc webp.',
            'thumbnail.max' => 'Dung lượng ảnh không được vượt quá 2048KB.',
            'name.required' => 'Tên sản phẩm không được để trống.',
            'categories.required' => 'Danh mục không được để trống.',
            'brands.required' => 'Thương hiệu không được để trống.',
            'sku.unique' => 'Mã SKU đã tồn tại.',
            'price.required' => 'Giá sản phẩm không được để trống.',
            'price.numeric' => 'Giá sản phẩm phải là số.',
            'price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
            'price_sale.numeric' => 'Giá khuyến mãi phải là số.',
            'price_sale.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
            'qty.required' => 'Số lượng sản phẩm không được để trống.',
            'description.required' => 'Mô tả sản phẩm không được để trống.',
            'description.max' => 'Mô tả sản phẩm không được vượt quá 500 ký tự.',
            'status.required' => 'Trạng thái không được để trống.',
            'quantities.*.integer' => 'Số lượng phải là số nguyên.',
            'quantities.*.min' => 'Số lượng không được nhỏ hơn 0.',
            'prices.*.numeric' => 'Giá phải là số.',
            'prices.*.min' => 'Giá không được nhỏ hơn 0.',
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

        $variant_types = $request->input('variant_types', []); // Đảm bảo là mảng, mặc định rỗng nếu null
        $variant_values = $request->input('variant_values', []);
        $quantities = $request->input('quantities', []);
        $prices = $request->input('prices', []);

        $variants = [];

        // Kiểm tra xem có bất kỳ loại biến thể hoặc giá trị biến thể nào không
        if (!empty($variant_types) && !empty($variant_values)) {
            // Xử lý vòng lặp để lấy đúng thông tin
            foreach ($variant_types as $typeIndex => $variant_type_id) {
                foreach ($variant_values as $valueIndex => $variant_value_id) {
                    // Tính chỉ số tương ứng cho số lượng và giá
                    $qtyIndex = $typeIndex * count($variant_values) + $valueIndex;
                    $priceIndex = $typeIndex * count($variant_values) + $valueIndex;

                    // Kiểm tra xem chỉ số tồn tại
                    if (isset($quantities[$qtyIndex]) && isset($prices[$priceIndex])) {
                        $qty = $quantities[$qtyIndex];
                        $price = str_replace(',', '', $prices[$priceIndex]); // Loại bỏ dấu phẩy nếu có trong giá

                        $variants[] = [
                            'product_id' => $product->id,
                            'variant_type_id' => $variant_type_id,
                            'variant_value_id' => $variant_value_id,
                            'qty' => $qty,
                            'price' => $price,
                        ];
                    }
                }
            }
        }


        // Lưu vào DB
        foreach ($variants as $variant) {
            // Lưu từng variant vào DB
            ProductVariant::create($variant);
        }

        return redirect()->route('admin.products.index')->with('success', 'Đã thêm sản phẩm thành công!');
    }

    public function show($id)
    {
        $product = Product::with(['variants.variantType','variants.variantValue','category','brand','tags','galleries']) ->findOrFail($id);
        // dd($product->variants);
        $variantTypes = $product->variants->groupBy('variantType.name');
        // dd($productVariant);
        return view('admin.products.show',compact('product','variantTypes'));
    }

    public function edit($id)
    {
        $product = Product::with(['variants.variantType', 'variants.variantValue'])->findOrFail($id);
        $categories = Category::all();
        $brands = Brands::all();
        $tags = Tag::all();
        // Truy vấn sản phẩm theo ID
        // dd($product);
        return view('admin.products.edit', compact('product', 'categories', 'brands', 'tags'));
    }
    public function update(Request $request, $id)
    {
        // Lấy sản phẩm theo ID
        $product = Product::findOrFail($id);

        // dd($request->all());
        // Cập nhật thông tin chung của sản phẩm
        $product->name = $request->input('name');
        $product->sku = $request->input('sku');
        $product->price = str_replace('.', '', $request->input('price')); // Loại bỏ dấu phẩy
        $product->price_sale = str_replace('.', '', $request->input('price_sale')); // Loại bỏ dấu phẩy
        $product->qty = $request->input('qty');
        $product->status = $request->input('status');
        $product->content = $request->input('content');
        $product->description = $request->input('description');
        $product->category_id = $request->input('categories');
        $product->brand_id = $request->input('brands');

        // Cập nhật ảnh đại diện nếu có thay đổi
        if ($request->hasFile('thumbnail')) {
            // Xóa ảnh cũ nếu có
            if ($product->thumbnail && Storage::exists($product->thumbnail)) {
                Storage::delete($product->thumbnail);
            }

            // Lưu ảnh mới
            $thumbnailPath = $request->file('thumbnail')->store('/uploads/products', 'public');
            $product->thumbnail = $thumbnailPath;
        }

        // Cập nhật các thẻ (tags)
        $product->tags()->sync($request->input('tags', []));

        // Lưu sản phẩm
        $product->save();

        // Xử lý cập nhật biến thể (variants)
        $variantQuantities = $request->input('quantities', []);
        $variantPrices = $request->input('prices', []);

        foreach ($product->variants as $key => $variant) {
            if (isset($variantQuantities[$key]) && isset($variantPrices[$key])) {
                // Cập nhật số lượng và giá của từng biến thể nếu tồn tại
                $variant->qty = (int) $variantQuantities[$key]; // Chuyển đổi thành số nguyên
                $variant->price = (float) str_replace(',', '', $variantPrices[$key]); // Loại bỏ dấu phẩy và chuyển thành số thực
                $variant->save();
            }
        }


        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response(['status' => 'success', 'Xóa thành công!']);
    }
//     public function deleteGallery($id)
// {

//     // Tìm ảnh theo ID
//     $gallery = ProductGallery::find($id);
//     // dd($gallery);
//     if ($gallery) {
//         // Xóa ảnh khỏi file storage
//         if (Storage::exists($gallery->image)) {
//             Storage::delete($gallery->image);
//         }

//         // Xóa ảnh khỏi cơ sở dữ liệu
//         $gallery->delete();

//         return response()->json(['success' => true, 'message' => 'Xóa ảnh thành công.']);
//     }

//     return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
// }


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
