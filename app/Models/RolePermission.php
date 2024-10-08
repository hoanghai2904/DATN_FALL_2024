<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePermission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'role_id',
        'permission_id',
    ];

    // Quan hệ với vai trò
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Quan hệ với quyền
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
