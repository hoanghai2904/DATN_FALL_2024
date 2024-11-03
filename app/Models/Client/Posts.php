<?php

namespace App\Models\Client;

use App\Models\User;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $table = "posts";
    public function User() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function Category() {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }
}
