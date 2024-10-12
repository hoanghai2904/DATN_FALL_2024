<?php

namespace App\Models;

use App\Models\admin\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'comments'; // Tên bảng trong cơ sở dữ liệu

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Định nghĩa mối quan hệ với model Product (nếu cần)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
