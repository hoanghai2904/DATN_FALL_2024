<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;

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
        return $this->belongsTo(Product::class,'product_id');
    }

    // public function product() {
    //     return $this->belongsTo('App\Models\Product','product_detail_id');
    //   }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_detail_id');
    }
    
    public function order_details() {
        return $this->hasMany(OrderDetail::class, 'product_detail_id');
      }
 
}
