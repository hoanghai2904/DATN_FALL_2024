<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderStatusEnum extends Enum
{
    const PENDING = 1;
    const CONFIRMED = 2;
    const PREPARING = 3;
    const DELIVERING = 4;
    const DELIVERED = 5;
    const COMPLETED = 6;
    const FAILED = 7;
    const CANCELLED = 8;
    const RETURN_PENDING = 9;
    const RETURNED = 10;
    const CANCELLED_RETURNED = 11;
    const CANCELLED_PENDING = 12;
    const CANCELLED_CANCELLED = 13;
    

    public static function getStatus()
    {
        return [
            self::PENDING => 'Chờ xác nhận',
            self::CONFIRMED => 'Đã xác nhận',
            self::PREPARING => 'Đang chuẩn bị',
            self::DELIVERING => 'Đang giao',
            self::DELIVERED => 'Đã giao',
            self::COMPLETED => 'Đơn hàng thành công',
            self::FAILED => 'Giao hàng thất bại',
            self::CANCELLED => 'Hủy',
            
            self::RETURN_PENDING => 'Chờ xác nhận hoàn hàng',
            self::RETURNED => 'Đã hoàn hàng',
            self::CANCELLED_RETURNED => 'Từ chối hoàn hàng',

            self::CANCELLED_PENDING => 'Chờ xác nhận hủy hàng',
            self::CANCELLED_CANCELLED => 'Từ chối hủy hàng',
        ];
    }
    
}
