<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VariantValue extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['variant_type_id', 'value'];

    public function variantType()
    {
        return $this->belongsTo(VariantType::class);
    }

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
