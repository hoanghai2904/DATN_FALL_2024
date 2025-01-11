<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVote extends Model
{
  use HasFactory,SoftDeletes;
  protected $fillable = [
      'content', 'rate', 'user_id', 'product_id'
  ];
  public function product() {
    return $this->belongsTo('App\Models\Product');
  }
  public function user() {
    return $this->belongsTo('App\Models\User');
  }
}
