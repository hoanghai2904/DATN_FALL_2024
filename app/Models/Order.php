<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'user_name',
        'user_email',
        'user_phone',
        'user_address',
        'user_note',
        'total_amount',
        'discount',
        'shipping_fee',
        'payment_status',
        'order_status',
        'payment_method',
       
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }

    public function address()
    {
        return $this->hasOne(UserAddress::class); // Thêm quan hệ với địa chỉ
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}