<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\ActiveAccountNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
<<<<<<< HEAD
        'full_name',
        'cover',
        'phone',
        'password',
        'email',
        'gender',
        'verification_token', 
        'birthday',
      
=======
        'name', 'email', 'phone', 'password', 'active_token','active',
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token', 'active_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function comments() {
        return $this->hasMany('App\Models\Comment');
    }
    public function notices() {
        return $this->hasMany('App\Models\Notice');
    }
    public function orders() {
        return $this->hasMany('App\Models\Order');
    }
    public function posts() {
        return $this->hasMany('App\Models\Post');
    }
    public function product_votes() {
        return $this->hasMany('App\Models\ProductVote');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Send the active account notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendActiveAccountNotification($token)
    {
        $this->notify(new ActiveAccountNotification($token));
    }

    public function userCoupons() {
        return $this->hasMany(UserCoupon::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'user_coupons');
    }
}
