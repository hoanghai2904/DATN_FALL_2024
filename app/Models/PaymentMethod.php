<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PaymentMethod extends Model
{
  use SoftDeletes;
  public function orders() {
    return $this->hasMany('App\Models\Order');
  }
}
