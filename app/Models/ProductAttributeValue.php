<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_id',
        'value',
    ];

    // Quan hệ với bảng ProductAttribute
    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }

    // Quan hệ với bảng ProductVariantAttribute
    public function variantAttributes()
    {
        return $this->hasMany(ProductVariantAttribute::class);
    }
}