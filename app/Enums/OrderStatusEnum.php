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
    const DELIVERING = 3;
    const DELIVERED = 4;
    const CANCELLED = 5;
}
