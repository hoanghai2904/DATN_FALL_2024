<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVote extends Model
{
  use HasFactory,SoftDeletes;

  protected $table = 'product_votes';
  protected $fillable = [
      'content', 'rate', 'user_id','order_detail_id','parent_id'
  ];
  public function product() {
    return $this->belongsTo('App\Models\Product');
  }
  public function user() {
    return $this->belongsTo('App\Models\User');
  }
  public function order_details(){
    return $this->belongsTo(OrderDetail::class,'order_detail_id');
  }
  public function replies()
{
    return $this->hasMany(ProductVote::class, 'parent_id');
}

public function parent()
{
    return $this->belongsTo(ProductVote::class, 'parent_id');
}
}
