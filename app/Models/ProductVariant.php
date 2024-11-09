<?php

namespace App\Models;

use App\Models\VariantType;
use App\Models\VariantValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_name',
        'sku',
        'price',
        'stock',
    ];

    // Quan hệ với bảng Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Quan hệ với bảng ProductVariantAttribute
    public function attributes()
    {
        return $this->hasMany(ProductVariantAttribute::class);
    }
}