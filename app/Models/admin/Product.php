<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'brand_id', 'thumbnail', 'name', 'slug', 'sku',
        'description', 'content', 'price', 'price_sale', 'product_type', 'status'
    ];
}
