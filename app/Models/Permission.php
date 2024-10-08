<?php

namespace App\Models;


use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    // Một quyền có thể thuộc về nhiều vai trò
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
