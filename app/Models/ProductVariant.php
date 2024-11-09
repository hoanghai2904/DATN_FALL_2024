<?php

namespace App\Models;

use App\Models\VariantType;
use App\Models\VariantValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'product_variant';

    protected $fillable = ['product_id', 'variant_type_id', 'variant_value_id', 'qty', 'price', 'image'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    // Trong model ProductVariant_
    public function variantType()
    {
        return $this->belongsTo(VariantType::class, 'variant_type_id');
    }

    public function variantValue()
    {
        return $this->belongsTo(VariantValue::class, 'variant_value_id');
    }
}
