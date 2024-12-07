<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'role_id',
    ];

    // Một người dùng có nhiều vai trò
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Một vai trò thuộc về nhiều người dùng
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
