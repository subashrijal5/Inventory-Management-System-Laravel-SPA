<?php

namespace App\Enums\Order;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

enum OrderFiltersEnum: string implements BaseEnumInterface
{
    use BaseEnumTrait;

    case ID           = 'id';
    case CUSTOMER_ID  = 'customer_id';
    case ORDER_NUMBER = 'order_number';
    case SUB_TOTAL    = 'sub_total';
    case TOTAL        = 'total';
    case DUE          = 'due';
    case PROFIT       = 'profit';
    case LOSS         = 'loss';
    case STATUS       = 'status';
    case CREATED_AT   = 'created_at';

    public static function labels(): array
    {
        return [
            self::ID->value           => __('enum_labels.order_fields.id'),
            self::CUSTOMER_ID->value  => __('enum_labels.order_fields.customer_id'),
            self::ORDER_NUMBER->value => __('enum_labels.order_fields.order_number'),
            self::SUB_TOTAL->value    => __('enum_labels.order_fields.sub_total'),
            self::TOTAL->value        => __('enum_labels.order_fields.total'),
            self::DUE->value          => __('enum_labels.order_fields.due'),
            self::PROFIT->value       => __('enum_labels.order_fields.profit'),
            self::LOSS->value         => __('enum_labels.order_fields.loss'),
            self::STATUS->value       => __('enum_labels.order_fields.status'),
            self::CREATED_AT->value   => __('enum_labels.order_fields.created_at'),
        ];
    }
}
