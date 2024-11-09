<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'variant_id',
        'attribute_id',
        'value_id',
    ];

    // Quan hệ với bảng ProductVariant
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    // Quan hệ với bảng ProductAttribute
    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }

    // Quan hệ với bảng ProductAttributeValue
    public function value()
    {
        return $this->belongsTo(ProductAttributeValue::class);
    }
}