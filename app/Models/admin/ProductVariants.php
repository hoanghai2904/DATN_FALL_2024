<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariants extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_id', 'product_type_id', 'product_weight_id', 'qty','price_variant' ,'image'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function type()
    {
        return $this->belongsTo(ProductTypes::class, 'product_type_id');
    }

    public function weight()
    {
        return $this->belongsTo(ProductWeights::class, 'product_weight_id');
    }
}
