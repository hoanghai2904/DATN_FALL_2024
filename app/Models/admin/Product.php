<?php

namespace App\Models\admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'brand_id', 'thumbnail', 'name', 'slug', 'sku','qty',
        'description', 'content', 'price', 'price_sale', 'product_type', 'status'
    ];
    public function categories(){
        return $this->belongsToMany(Category::class, 'category_id');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariants::class);
    }
}
