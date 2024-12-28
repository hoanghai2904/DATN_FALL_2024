<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'attributes',
        'price',
        'stock_quantity',
        'purchase_price',
        'price',
        'promotion_price',
        'promotion_start_date',
        'promotion_end_date'
    ];

    protected $casts = [
        'attributes' => 'array', // Lưu dưới dạng JSON
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
