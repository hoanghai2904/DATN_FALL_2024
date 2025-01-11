<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
  use SoftDeletes;
  protected $fillable = ['order_id', 'product_detail_id', 'quantity', 'price'];
  public function order() {
    return $this->belongsTo('App\Models\Order');
  }
  // public function product_detail() {
  //   return $this->belongsTo('App\Models\ProductDetail');
  // }

  public function variants()
    {
        
        return $this->belongsTo(ProductVariant::class, 'product_detail_id','id');
    }
    
}
