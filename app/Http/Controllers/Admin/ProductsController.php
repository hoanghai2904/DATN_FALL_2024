<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;
use App\Models\Producer;
use App\Models\Promotion;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Models\OrderDetail;
use App\Models\ProductVariant;

class ProductsController extends Controller
{
  public function index()
  {
    $products = Product::withTrashed()->select('id', 'producer_id', 'name', 'image', 'sku_code', 'stock', 'rate', 'created_at')
      ->whereHas('variants', function (Builder $query) {
        $query->where('stock_quantity', '>', 0);
      })
      ->with([
        'producer' => function ($query) {
          $query->select('id', 'name');
        }
      ])
      ->withCount([
        'variants' => function (Builder $query) {
          $query->withTrashed()->where([['stock_quantity', '>', 0]]);
        }
      ])->latest()->get();
      // dd($products);

    return view('admin.products.index')->with('products', $products);
  }

  public function delete(Request $request)
  {
    $product = Product::with(['variants.images', 'promotions', 'product_votes'])->where('id', $request->product_id)->first();

    // Kiểm tra nếu sản phẩm không tồn tại
    if (!$product) {
      return response()->json([
        'type' => 'error',
        'title' => 'Thất Bại',
        'content' => 'Sản phẩm không tồn tại!',
      ], 404);
    }

    // Xóa tất cả các biến thể và hình ảnh liên quan
    foreach ($product->variants as $variant) {
      // Xóa hình ảnh liên quan đến biến thể
      foreach ($variant->images as $image) {
        Storage::disk('public')->delete('images/products/' . $image->image_name);
        $image->delete();
      }
      // Xóa biến thể
      $variant->delete();
    }

    // Xóa tất cả các khuyến mãi liên quan đến sản phẩm
    foreach ($product->promotions as $promotion) {
      $promotion->delete();
    }

    // Xóa tất cả bình chọn liên quan đến sản phẩm
    foreach ($product->product_votes as $product_vote) {
      $product_vote->delete();
    }

    // Xóa sản phẩm chính
    $product->delete();

    return response()->json([
      'type' => 'success',
      'title' => 'Thành Công',
      'content' => 'Xóa sản phẩm cùng với tất cả dữ liệu liên quan thành công!',
    ], 200);
  }



  public function new(Request $request)
  {
    $producers = Producer::select('id', 'name')->orderBy('name', 'asc')->get();

    // Lấy tất cả thuộc tính và giá trị của từng thuộc tính
    $attributes = Attribute::withTrashed()->with('values')->get();

    return view('admin.products.new', [
      'producers' => $producers,
      'attributes' => $attributes,
    ]);
  }


  public function save(Request $request)
  {
    // dd($request);    
    $product = new Product;

    if ($request->information_details != null) {
      //Xử lý Ảnh trong nội dung
      $information_details = $request->information_details;

      $dom = new \DomDocument();

      // conver utf-8 to html entities
      $information_details = mb_convert_encoding($information_details, 'HTML-ENTITIES', "UTF-8");

      $dom->loadHtml($information_details, LIBXML_HTML_NODEFDTD);

      $images = $dom->getElementsByTagName('img');

      foreach ($images as $k => $img) {

        $data = $img->getAttribute('src');

        if (Str::containsAll($data, ['data:image', 'base64'])) {

          list(, $type) = explode('data:image/', $data);
          list($type,) = explode(';base64,', $type);

          list(, $data) = explode(';base64,', $data);

          $data = base64_decode($data);

          $image_name = time() . $k . '_' . Str::random(8) . '.' . $type;

          Storage::disk('public')->put('images/posts/' . $image_name, $data);

          $img->removeAttribute('src');
          $img->setAttribute('src', '/storage/images/posts/' . $image_name);
        }
      }

      $information_details = $dom->saveHTML();

      //conver html-entities to utf-8
      $information_details = mb_convert_encoding($information_details, "UTF-8", 'HTML-ENTITIES');

      //get content
      list(, $information_details) = explode('<html><body>', $information_details);
      list($information_details,) = explode('</body></html>', $information_details);

      $product->information_details = $information_details;
    }
    if ($request->product_introduction != null) {
      //Xử lý Ảnh trong nội dung
      $product_introduction = $request->product_introduction;

      $dom = new \DomDocument();

      // conver utf-8 to html entities
      $product_introduction = mb_convert_encoding($product_introduction, 'HTML-ENTITIES', "UTF-8");

      $dom->loadHtml($product_introduction, LIBXML_HTML_NODEFDTD);

      $images = $dom->getElementsByTagName('img');

      foreach ($images as $k => $img) {

        $data = $img->getAttribute('src');

        if (Str::containsAll($data, ['data:image', 'base64'])) {

          list(, $type) = explode('data:image/', $data);
          list($type,) = explode(';base64,', $type);

          list(, $data) = explode(';base64,', $data);

          $data = base64_decode($data);

          $image_name = time() . $k . '_' . Str::random(8) . '.' . $type;

          Storage::disk('public')->put('images/posts/' . $image_name, $data);

          $img->removeAttribute('src');
          $img->setAttribute('src', '/storage/images/posts/' . $image_name);
        }
      }

      $product_introduction = $dom->saveHTML();

      //conver html-entities to utf-8
      $product_introduction = mb_convert_encoding($product_introduction, "UTF-8", 'HTML-ENTITIES');

      //get content
      list(, $product_introduction) = explode('<html><body>', $product_introduction);
      list($product_introduction,) = explode('</body></html>', $product_introduction);

      $product->product_introduction = $product_introduction;
    }

    $product->name = $request->name;
    $product->producer_id = $request->producer_id;
    $product->sku_code = $request->sku_code;
    $product->rate = 5.0;

    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $image_name = time() . '_' . Str::random(8) . '_' . $image->getClientOriginalName();
      $image->storeAs('images/products', $image_name, 'public');
      $product->image = $image_name;
    }

    $product->save();

    if ($request->has('product_promotions')) {
      foreach ($request->product_promotions as $product_promotion) {
        $promotion = new Promotion;
        $promotion->product_id = $product->id;
        $promotion->content = $product_promotion['content'];

        //Xử lý ngày bắt đầu, ngày kết thúc
        list($start_date, $end_date) = explode(' - ', $product_promotion['promotion_date']);

        $start_date = str_replace('/', '-', $start_date);
        $start_date = date('Y-m-d', strtotime($start_date));

        $end_date = str_replace('/', '-', $end_date);
        $end_date = date('Y-m-d', strtotime($end_date));

        $promotion->start_date = $start_date;
        $promotion->end_date = $end_date;

        $promotion->save();
      }
    }


    $totalStock = 0; // Khởi tạo tổng số lượng

    foreach ($request->product_details as $key => $product_detail) {
        $attributes = $request->get('attributes');
        $attributeValues = $attributes[0]['attribute'];
        $attributesString = implode('-', $attributeValues);
    
        $sku = $product->sku_code . '-' . $product_detail['sku'];
    
        // Kiểm tra nếu SKU đã tồn tại (bao gồm cả bản ghi đã xóa mềm)
        $existingProductDetail = ProductVariant::withTrashed()->where('sku', $sku)->first();
    
        if ($existingProductDetail) {
            // Nếu SKU đã tồn tại, khôi phục bản ghi (xóa deleted_at)
            $existingProductDetail->restore();
            $existingProductDetail->attributes = $attributesString;
            $existingProductDetail->stock_quantity = $product_detail['quantity'];
            $existingProductDetail->purchase_price = str_replace('.', '', $product_detail['import_price']);
            $existingProductDetail->price = str_replace('.', '', $product_detail['sale_price']);
            $totalStock += $product_detail['quantity']; // Tăng tổng số lượng
    
            if ($product_detail['promotion_price'] != null) {
                $existingProductDetail->promotion_price = str_replace('.', '', $product_detail['promotion_price']);
            }
    
            if ($product_detail['promotion_date'] != null) {
                list($start_date, $end_date) = explode(' - ', $product_detail['promotion_date']);
                $start_date = str_replace('/', '-', $start_date);
                $start_date = date('Y-m-d', strtotime($start_date));
                $end_date = str_replace('/', '-', $end_date);
                $end_date = date('Y-m-d', strtotime($end_date));
    
                $existingProductDetail->promotion_start_date = $start_date;
                $existingProductDetail->promotion_end_date = $end_date;
            }
    
            $existingProductDetail->save();
        } else {
            // Nếu SKU không tồn tại, tạo mới sản phẩm biến thể
            $new_product_detail = new ProductVariant;
            $new_product_detail->product_id = $product->id;
            $new_product_detail->sku = $sku;
            $new_product_detail->attributes = $attributesString;
            $new_product_detail->stock_quantity = $product_detail['quantity'];
            $new_product_detail->purchase_price = str_replace('.', '', $product_detail['import_price']);
            $new_product_detail->price = str_replace('.', '', $product_detail['sale_price']);
            $totalStock += $product_detail['quantity']; // Tăng tổng số lượng
    
            if ($product_detail['promotion_price'] != null) {
                $new_product_detail->promotion_price = str_replace('.', '', $product_detail['promotion_price']);
            }
    
            if ($product_detail['promotion_date'] != null) {
                list($start_date, $end_date) = explode(' - ', $product_detail['promotion_date']);
                $start_date = str_replace('/', '-', $start_date);
                $start_date = date('Y-m-d', strtotime($start_date));
                $end_date = str_replace('/', '-', $end_date);
                $end_date = date('Y-m-d', strtotime($end_date));
    
                $new_product_detail->promotion_start_date = $start_date;
                $new_product_detail->promotion_end_date = $end_date;
            }
    
            $new_product_detail->save();
    
            // Lưu hình ảnh cho sản phẩm biến thể
            foreach ($request->file('product_details')[$key]['images'] as $image) {
                $image_name = time() . '_' . Str::random(8) . '_' . $image->getClientOriginalName();
                $image->storeAs('images/products', $image_name, 'public');
    
                $new_image = new ProductImage;
                $new_image->product_detail_id = $new_product_detail->id;
                $new_image->image_name = $image_name;
    
                $new_image->save();
            }
        }
    }
    
    // Sau khi xử lý xong tất cả các biến thể, cập nhật stock của sản phẩm
    $product->stock = $totalStock; // Gán tổng số lượng
    $product->save(); // Lưu lại thay đổi
    

    return redirect()->route('admin.products.index')->with(['alert' => [
      'type' => 'success',
      'title' => 'Thành Công',
      'content' => 'Thêm sản phẩm thành công.'
    ]]);
  }

  public function edit($id)
  {
    $producers = Producer::select('id', 'name')->orderBy('name', 'asc')->get();

    $product = Product::with([
      'promotions:id,product_id,content,start_date,end_date',
      'variants' => function ($query) {
        $query->select('id', 'product_id', 'sku', 'attributes', 'stock_quantity', 'purchase_price', 'price', 'promotion_price', 'promotion_start_date', 'promotion_end_date')
          ->with('images:id,product_detail_id,image_name')
          ->where('stock_quantity', '>', 0);
      }
    ])->findOrFail($id);
    $attributeIds = $product->variants->pluck('attributes')->map(function ($attributes) {
      // Nếu 'attributes' là chuỗi, chuyển thành mảng hoặc xử lý tương ứng
      return explode('-', $attributes); // Tách giá trị thuộc tính từ SKU
    })->flatten()->unique();
    // Lấy danh sách các SKU đã được chọn
    $skuList = $product->variants->pluck('sku')->map(function ($sku) {
      return explode('-', $sku); // Tách giá trị thuộc tính từ SKU
    })->flatten()->unique(); // Lấy giá trị thuộc tính duy nhất

    $attributes = Attribute::select('id', 'name')->orderBy('name')->get();

    $attributes_value = Attribute::with('values')
      ->whereIn('id', $attributeIds->toArray()) // Chuyển collection thành mảng
      ->orderByRaw("FIELD(id, ?)", [$attributeIds->implode(',')]) // Dùng implode trên mảng
      ->get();
    // dd($product);
    return view('admin.products.edit', compact('product', 'attributes', 'attributeIds', 'attributes_value', 'skuList', 'producers'));
  }


  public function update(Request $request, $id)
  {
      // dd($request, $id);
    $product = Product::whereHas('variants', function (Builder $query) {
      $query->where('stock_quantity', '>', 0);
    })->where('id', $id)->first();
    if (!$product) abort(404);

    if ($request->information_details != null) {
      //Xử lý Ảnh trong nội dung
      $information_details = $request->information_details;

      $dom = new \DomDocument();

      // conver utf-8 to html entities
      $information_details = mb_convert_encoding($information_details, 'HTML-ENTITIES', "UTF-8");

      $dom->loadHtml($information_details, LIBXML_HTML_NODEFDTD);

      $images = $dom->getElementsByTagName('img');

      foreach ($images as $k => $img) {

        $data = $img->getAttribute('src');

        if (Str::containsAll($data, ['data:image', 'base64'])) {

          list(, $type) = explode('data:image/', $data);
          list($type,) = explode(';base64,', $type);

          list(, $data) = explode(';base64,', $data);

          $data = base64_decode($data);

          $image_name = time() . $k . '_' . Str::random(8) . '.' . $type;

          Storage::disk('public')->put('images/posts/' . $image_name, $data);

          $img->removeAttribute('src');
          $img->setAttribute('src', '/storage/images/posts/' . $image_name);
        }
      }

      $information_details = $dom->saveHTML();

      //conver html-entities to utf-8
      $information_details = mb_convert_encoding($information_details, "UTF-8", 'HTML-ENTITIES');

      //get content
      list(, $information_details) = explode('<html><body>', $information_details);
      list($information_details,) = explode('</body></html>', $information_details);

      $product->information_details = $information_details;
    }

    $product->name = $request->name_product;
    $product->producer_id = $request->producer_id;
    $product->sku_code = $request->sku_code;

    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $image_name = time() . '_' . Str::random(8) . '_' . $image->getClientOriginalName();
      $image->storeAs('images/products', $image_name, 'public');
      Storage::disk('public')->delete('images/products/' . $product->image);
      $product->image = $image_name;
    }

    $product->save();

    if ($request->has('old_product_promotions')) {
      foreach ($request->old_product_promotions as $key => $old_product_promotion) {
        $promotion = Promotion::where('id', $key)->first();
        if (!$promotion) abort(404);

        $promotion->content = $old_product_promotion['content'];

        //Xử lý ngày bắt đầu, ngày kết thúc
        list($start_date, $end_date) = explode(' - ', $old_product_promotion['promotion_date']);

        $start_date = str_replace('/', '-', $start_date);
        $start_date = date('Y-m-d', strtotime($start_date));

        $end_date = str_replace('/', '-', $end_date);
        $end_date = date('Y-m-d', strtotime($end_date));

        $promotion->start_date = $start_date;
        $promotion->end_date = $end_date;

        $promotion->save();
      }
    }

    if ($request->has('product_promotions')) {
      foreach ($request->product_promotions as $product_promotion) {
        $promotion = new Promotion;
        $promotion->product_id = $product->id;
        $promotion->content = $product_promotion['content'];

        //Xử lý ngày bắt đầu, ngày kết thúc
        list($start_date, $end_date) = explode(' - ', $product_promotion['promotion_date']);

        $start_date = str_replace('/', '-', $start_date);
        $start_date = date('Y-m-d', strtotime($start_date));

        $end_date = str_replace('/', '-', $end_date);
        $end_date = date('Y-m-d', strtotime($end_date));

        $promotion->start_date = $start_date;
        $promotion->end_date = $end_date;

        $promotion->save();
      }
    }

    if ($request->has('old_product_details')) {
      $totalStock = 0;
      foreach ($request->old_product_details as $key => $product_detail) {
          $old_product_detail = ProductVariant::find($key);
          if (!$old_product_detail) abort(404);
  
          $old_product_detail->stock_quantity = (int) $product_detail['quantity'];
          $old_product_detail->purchase_price = str_replace('.', '', $product_detail['import_price']);
          $old_product_detail->price = str_replace('.', '', $product_detail['sale_price']);
          $totalStock += (int) $product_detail['quantity'];
  
          if (!empty($product_detail['promotion_price'])) {
              $old_product_detail->promotion_price = str_replace('.', '', $product_detail['promotion_price']);
          }
  
          if (!empty($product_detail['promotion_date']) && strpos($product_detail['promotion_date'], ' - ') !== false) {
              list($start_date, $end_date) = explode(' - ', $product_detail['promotion_date']);
              $old_product_detail->promotion_start_date = date('Y-m-d', strtotime(str_replace('/', '-', $start_date)));
              $old_product_detail->promotion_end_date = date('Y-m-d', strtotime(str_replace('/', '-', $end_date)));
          }
  
          $old_product_detail->save();
      }
  
      $product->stock = $totalStock;
      $product->save();
  }
  
  if ($request->has('product_details') && $request->has('values')) {
    
    $totalStock = 0;
      foreach ($request->product_details as $key => $product_detail) {
          $attributes = $request->get('attributes');
          $attributeValues = isset($attributes[0]['attribute']) ? $attributes[0]['attribute'] : [];
          $attributesString = implode('-', $attributeValues);
  
          $new_product_detail = new ProductVariant;
          $new_product_detail->product_id = $product->id;
          $new_product_detail->sku = $product->sku_code . '-' . $product_detail['sku'];
          $new_product_detail->attributes = $attributesString;
          $new_product_detail->stock_quantity = (int) $product_detail['quantity'];
          $new_product_detail->purchase_price = str_replace('.', '', $product_detail['import_price']);
          $new_product_detail->price = str_replace('.', '', $product_detail['sale_price']);
          $totalStock += (int) $product_detail['quantity'];
  
          if (!empty($product_detail['promotion_price'])) {
              $new_product_detail->promotion_price = str_replace('.', '', $product_detail['promotion_price']);
          }
  
          if (!empty($product_detail['promotion_date']) && strpos($product_detail['promotion_date'], ' - ') !== false) {
              list($start_date, $end_date) = explode(' - ', $product_detail['promotion_date']);
              $new_product_detail->promotion_start_date = date('Y-m-d', strtotime(str_replace('/', '-', $start_date)));
              $new_product_detail->promotion_end_date = date('Y-m-d', strtotime(str_replace('/', '-', $end_date)));
          }
  
          $new_product_detail->save();
  
          foreach ($request->file('product_details')[$key]['images'] as $image) {
              $image_name = uniqid() . '_' . Str::random(8) . '_' . $image->getClientOriginalName();
              $image->storeAs('images/products', $image_name, 'public');
  
              $new_image = new ProductImage;
              $new_image->product_detail_id = $new_product_detail->id;
              $new_image->image_name = $image_name;
              $new_image->save();
          }
      }
  
      $product->stock += $totalStock;
      $product->save();
  }
  
  if ($request->file('old_product_details') != null) {
      foreach ($request->file('old_product_details') as $key => $images) {
          foreach ($images['images'] as $image) {
              $image_name = uniqid() . '_' . Str::random(8) . '_' . $image->getClientOriginalName();
              $image->storeAs('images/products', $image_name, 'public');
  
              $new_image = new ProductImage;
              $new_image->product_detail_id = $key;
              $new_image->image_name = $image_name;
              $new_image->save();
          }
      }
  }
  

    return redirect()->route('admin.products.index')->with(['alert' => [
      'type' => 'success',
      'title' => 'Thành Công',
      'content' => 'Chỉnh sửa sản phẩm thành công.'
    ]]);
  }

  public function delete_promotion(Request $request)
  {
    $promotion = Promotion::where('id', $request->promotion_id)->first();

    if (!$promotion) {

      $data['type'] = 'error';
      $data['title'] = 'Thất Bại';
      $data['content'] = 'Bạn không thể xóa khuyễn mãi không tồn tại!';
    } else {

      $promotion->delete();

      $data['type'] = 'success';
      $data['title'] = 'Thành Công';
      $data['content'] = 'Xóa khuyến mãi thành công!';
    }

    return response()->json($data, 200);
  }

  public function delete_product_detail(Request $request)
  {
      // Tìm ProductVariant có id khớp và stock_quantity > 0
      $product_detail = ProductVariant::where([['id', $request->product_detail_id], ['stock_quantity', '>', 0]])->first();
  
      if (!$product_detail) {
          // Trường hợp không tìm thấy chi tiết sản phẩm
          $data = [
              'type' => 'error',
              'title' => 'Thất Bại',
              'content' => 'Bạn không thể xóa chi tiết sản phẩm không tồn tại hoặc số lượng bằng 0!',
          ];
      } else {
          try {
              // Xóa ảnh liên quan đến chi tiết sản phẩm
              foreach ($product_detail->images as $image) {
                  Storage::disk('public')->delete('images/products/' . $image->image_name);
                  $image->delete();
              }
  
              // Lấy sản phẩm liên quan
              $product = $product_detail->product;
  
              // Cập nhật stock trong bảng product
              $product->stock -= $product_detail->stock_quantity;
              $product->save();
  
              // Xóa chi tiết sản phẩm
              $product_detail->delete();
  
              // Phản hồi thành công
              $data = [
                  'type' => 'success',
                  'title' => 'Thành Công',
                  'content' => 'Xóa chi tiết sản phẩm thành công!',
              ];
          } catch (\Exception $e) {
              // Phản hồi nếu xảy ra lỗi
              $data = [
                  'type' => 'error',
                  'title' => 'Lỗi Hệ Thống',
                  'content' => 'Đã xảy ra lỗi khi xóa chi tiết sản phẩm. Vui lòng thử lại sau!',
                  'error' => $e->getMessage(),
              ];
          }
      }
  
      return response()->json($data, 200);
  }
  

  public function deleteImage(Request $request)
  {
    $image = ProductImage::find($request->key);
    Storage::disk('public')->delete('images/products/' . $image->image_name);
    $image->delete();
    return response()->json();
  }
}
