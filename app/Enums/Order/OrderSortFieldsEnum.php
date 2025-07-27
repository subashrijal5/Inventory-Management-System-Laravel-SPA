<?php

namespace App\Enums\Order;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

enum OrderSortFieldsEnum: string implements BaseEnumInterface
{
    use BaseEnumTrait;

    case ID             = 'id';
    case CUSTOMER_ID    = 'customer_id';
    case SUB_TOTAL      = 'sub_total';
    case DISCOUNT_TOTAL = 'discount_total';
    case TOTAL          = 'total';
    case PAID           = 'paid';
    case DUE            = 'due';
    case PROFIT         = 'profit';
    case LOSS           = 'loss';
    case STATUS         = 'status';
    case CREATED_AT     = 'created_at';

    public static function labels(): array
    {
        return [
            self::ID->value             => __('enum_labels.order_sort_fields.id'),
            self::CUSTOMER_ID->value    => __('enum_labels.order_sort_fields.customer_id'),
            self::SUB_TOTAL->value      => __('enum_labels.order_sort_fields.sub_total'),
            self::DISCOUNT_TOTAL->value => __('enum_labels.order_sort_fields.discount_total'),
            self::TOTAL->value          => __('enum_labels.order_sort_fields.total'),
            self::PAID->value           => __('enum_labels.order_sort_fields.paid'),
            self::DUE->value            => __('enum_labels.order_sort_fields.due'),
            self::PROFIT->value         => __('enum_labels.order_sort_fields.profit'),
            self::LOSS->value           => __('enum_labels.order_sort_fields.loss'),
            self::STATUS->value         => __('enum_labels.order_sort_fields.status'),
            self::CREATED_AT->value     => __('enum_labels.order_sort_fields.created_at'),
        ];
    }
}
