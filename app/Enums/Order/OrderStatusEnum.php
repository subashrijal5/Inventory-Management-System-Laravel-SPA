<?php

namespace App\Enums\Order;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

enum OrderStatusEnum: string implements BaseEnumInterface
{
    use BaseEnumTrait;

    case PAID         = 'paid';
    case UNPAID       = 'unpaid';
    case PARTIAL_PAID = 'partial_paid';
    case OVER_PAID    = 'over_paid';
    case SETTLED      = 'settled';

    public static function labels(): array
    {
        return [
            self::PAID->value         => __('enum_labels.order_status.paid'),
            self::UNPAID->value       => __('enum_labels.order_status.unpaid'),
            self::PARTIAL_PAID->value => __('enum_labels.order_status.partial_paid'),
            self::OVER_PAID->value    => __('enum_labels.order_status.over_paid'),
            self::SETTLED->value      => __('enum_labels.order_status.settled'),
        ];
    }
}
