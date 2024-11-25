<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    protected $guarded = [];
    public function products() {
      return $this->hasMany('App\Models\Product');
    }
}
