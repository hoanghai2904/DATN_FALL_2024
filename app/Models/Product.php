<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
  use HasFactory, SoftDeletes;
  protected $fillable = [
    'producer_id',
    'name',
    'image',
    'sku_code',
    'stock',
    'information_details',
    'product_introduction',
    'rate'
  ];
  //varian
  public function variants()
  {
    return $this->hasMany(ProductVariant::class,'product_id', 'id');
  }

  // public function variants() {
  //   return $this->belongsTo('App\Models\ProductVariant','product_id', 'id');
  // }
  // khác 
  public function advertises()
  {
    return $this->hasMany('App\Models\Advertise');
  }
  public function comments()
  {
    return $this->hasMany('App\Models\Comment');
  }
  public function product_votes()
  {
    return $this->hasMany('App\Models\ProductVote');
  }
  public function promotions()
  {
    return $this->hasMany('App\Models\Promotion');
  }
  public function product_details()
  {
    return $this->hasMany('App\Models\ProductDetail');
  }
  public function producer()
  {
    return $this->belongsTo('App\Models\Producer');
  }
  public function product_detail()
  {
    return $this->hasOne('App\Models\ProductDetail', 'product_id', 'id');
  }
}
