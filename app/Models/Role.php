<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'status'];

    // Một vai trò có thể có nhiều người dùng
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
    }

    // Một vai trò có thể có nhiều quyền
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }
}
