<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Khai báo quan hệ với model UserAddress
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',     // ID vai trò
        'full_name',   // Họ và tên người dùng
        'cover',       // Đường dẫn ảnh bìa người dùng
        'phone',       // SĐT người dùng
        'email',       // Email người dùng
        'password',    // Mật khẩu người dùng
        'gender',      // Giới tính
        'status',      // Trạng thái tài khoản
        'remember_token', // Token ghi nhớ đăng nhập
        'email_verified_at', // Thời điểm email xác thực
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Set the user's password.
     *
     * @param  string  $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
