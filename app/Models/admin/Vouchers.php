<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
    use HasFactory;
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
}
