<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'status',
        ' updated_at',
        ' created_at'

    ];



    // protected $casts = [
    //     'is_active' => 'boolean'
    // ];

    // public function products()
    // {
    //     return $this->hasMany(Product::class);
    // }
}
