<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductWeights extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function variants()
    {
        return $this->hasMany(ProductVariants::class, 'product_weight_id');
    }
}
