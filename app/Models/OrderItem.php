<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_variant_id', 'qty', 'product_name',  
        'product_thumbnail', 'product_price', 'product_price_sale', 
        'variant_size_name', 'variant_color_name'
    ];

    // Quan hệ ngược lại với Order
  
    public function order()
{
    return $this->belongsTo(Order::class, 'order_id');
}
}