<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';


    protected $fillable = [
        'id',
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
        'product_type',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
