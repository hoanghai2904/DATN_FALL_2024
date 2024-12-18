<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDetail extends Model
{
  use SoftDeletes;
  public function product() {
    return $this->belongsTo('App\Models\Product');
  }
  public function product_images() {
    return $this->hasMany('App\Models\ProductImage');
  }
  public function order_details() {
    return $this->hasMany('App\Models\OrderDetail');
  }
}
