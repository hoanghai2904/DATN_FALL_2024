<?php

namespace App\Models\admin;

use App\Models\Category;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posts extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "posts";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'thumbnail',
        'category_id',
        'title',
        'body',
        'status',
        ];
        public function User() {
            return $this->belongsTo(User::class, 'user_id');
        }
        public function Category() {
            return $this->belongsTo(PostCategory::class, 'category_id');
        }
}
