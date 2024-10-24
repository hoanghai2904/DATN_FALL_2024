<?php

namespace App\Models;
use App\Models\User;
use App\Models\admin\Product;
use App\Models\Order_statuses;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'reviews'; 
    protected $fillable = [

        'user_id',
        'order_status_id',
        'product_id',
        'rating',
        'comment',

    ];
    public $timestamp = false;

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function Order_statuses()
    {
        return $this->belongsTo(Order_statuses::class, 'order_id');
    }
    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }   
    
}
