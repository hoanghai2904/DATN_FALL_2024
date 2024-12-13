<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
  use SoftDeletes;
  public function order() {
    return $this->belongsTo('App\Models\Order');
  }
  public function product_detail() {
    return $this->belongsTo('App\Models\ProductDetail');
  }
}
