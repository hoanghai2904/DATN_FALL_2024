<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'voucher_id', 'user_name', 'user_email', 'user_phone', 
        'user_address', 'user_note', 'status_order', 'shipping_fee', 
        'total_price', 'discount_price', 'payment_method'
    ];

    // Quan hệ 1-nhiều với OrderItem
    public function items() 
    {
        return $this->hasMany(OrderItem::class);
    }
    use HasFactory;

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
