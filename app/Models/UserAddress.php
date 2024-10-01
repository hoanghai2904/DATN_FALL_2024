<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_addresses';

    // Khai báo các cột có thể được gán giá trị
    protected $fillable = [
        'user_id',
        'full_name',
        'cover',
        'phone',
        'address',
        'email',
        'province_id',
        'district_id',
        'ward_id',
        'is_default',
    ];

    /**
     * Quan hệ với model User (người dùng)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Soft delete timestamps.
     */
    protected $dates = ['deleted_at'];
}
