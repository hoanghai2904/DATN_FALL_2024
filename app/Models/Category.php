<?php

namespace App\Models;

use App\Models\Product;
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
    public function parent()
    {

        return $this->belongsToMany(Category::class, 'parent_category', 'category_id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
