<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $fillable = ['district_id', 'name'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function userAddresses()
    {
        return $this->hasMany(UserAddress::class);
    }
}
