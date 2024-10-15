<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'cover',
        'phone',
        'password',
        'email',
        'gender',
        'verification_token',
        'birthday',
    ];

    // Một người dùng thuộc về một vai trò
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    // Một người dùng có nhiều quyền qua bảng role_permissions
    public function permissions()
    {
        return $this->hasManyThrough(
            Permission::class,  // Model mà bạn muốn lấy
            RolePermission::class, // Bảng trung gian
            'role_id',          // Foreign key trên bảng trung gian
            'id',               // Foreign key trên bảng permissions
            'id',               // Local key trên bảng users
            'permission_id'     // Local key trên bảng role_permissions
        );
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

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
}

?>