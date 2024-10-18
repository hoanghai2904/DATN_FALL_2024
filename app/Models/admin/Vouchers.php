<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vouchers extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "vouchers";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $fillable = [
    'code',
    'name',
    'discount_type',
    'status',
    'discount',
    'qty',
    'start',
    'end'
    ];
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
