<?php

namespace App\Models\admin;

use App\Models\Brands;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'category_id', 'brand_id', 'thumbnail', 'name', 'slug', 'sku','qty',
        'description', 'content', 'price', 'price_sale', 'status'
    ];

    // Thiết lập quan hệ với bảng ProductVariant
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    // Quan hệ với bảng Category 
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Quan hệ với bảng Brand 
    public function brand()
    {
        return $this->belongsTo(Brands::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class, 'product_tags');
    }
    public function galleries(){
        return $this->hasMany(ProductGallery::class);
    }
  
}
