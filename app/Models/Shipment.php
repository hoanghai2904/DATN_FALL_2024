<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'carrier_name',
        'tracking_number',
        'shipping_status',
        'shipped_at',
        'delivered_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
