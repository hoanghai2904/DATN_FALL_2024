<?php

namespace App\Models;

use App\Models\Client\Posts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'post_categories';
    protected $fillable = [
        'name',
        'status',
        ' updated_at',
        ' created_at'

    ];
    public function posts() {
        return $this->hasMany(Posts::class, 'category_id');
    }
}
