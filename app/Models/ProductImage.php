<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
  use HasFactory,SoftDeletes;

    protected $fillable = ['product_detail_id', 'image_name'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variants()
    {
        
        return $this->belongsTo(ProductVariant::class, 'product_detail_id');
    }
    
    
  public function product_detail() {
    return $this->belongsTo('App\Models\ProductDetail');
  }
  
}
