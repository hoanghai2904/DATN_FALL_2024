<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VariantType extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name'];

    public function variantValues()
    {
        return $this->hasMany(VariantValue::class);
    }
}
