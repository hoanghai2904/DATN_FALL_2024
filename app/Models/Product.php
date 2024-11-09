<?php

namespace App\Models;

use App\Models\ProductGallery;
use App\Models\ProductVariants;
use App\Models\Tag;
use App\Models\Brands;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
        'thumbnail',
        'name',
        'slug',
        'sku',
        'qty',
        'description',
        'content',
        'price',
        'price_sale',
        'status'
    ];
    // public function categories(){
    //     return $this->belongsToMany(Category::class, 'category_id');
    // }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }


    public function productVariants()
    {
        return $this->hasManyThrough(VariantValue::class, ProductVariant::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brands::class);
    }
    // belongsToMany : thiết lập mối quan hệ nhiều-nhiều giữa hai model.
    // Tag::class là tham chiếu đến class Tag. Nó chỉ ra rằng Product có quan hệ với Tag
    // 'product_tags' : bảng trung gian (pivot table) kết nối hai bảng products và tags.
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }
    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function OrderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function brands()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
    }
}
