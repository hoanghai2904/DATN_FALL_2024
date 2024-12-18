<?php

namespace App\Models\Client;

use App\Models\Client\Posts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCate extends Model
{
    use HasFactory;
    protected $table = "post_categories";
    protected $primaryKey = "id";

    public $timestamps = true;

    protected $attributes = [

    ];

    protected $fillable = [
        'name'
    ];
    public function posts() {
        return $this->hasMany(Posts::class, 'category_id');
    }
}
