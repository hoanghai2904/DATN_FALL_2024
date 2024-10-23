<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    // Tên bảng tương ứng trong database
    protected $table = 'password_reset_tokens';

    // Không có cột `id` vì email là khóa chính
    public $incrementing = false;

    // Định nghĩa khóa chính
    protected $primaryKey = 'email';
    protected $keyType = 'string';

    // Các cột có thể được gán giá trị hàng loạt (mass assignable)
    protected $fillable = ['email', 'token', 'created_at'];

    // Tắt timestamps vì chúng ta chỉ có 'created_at'
    public $timestamps = false;

    // Gán created_at tự động nếu chưa được cung cấp
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->created_at) {
                $model->created_at = Carbon::now();
            }
        });
    }
    
    

}