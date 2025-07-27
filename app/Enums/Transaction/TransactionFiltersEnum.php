<?php

namespace App\Enums\Transaction;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

enum TransactionFiltersEnum: string implements BaseEnumInterface
{
    use BaseEnumTrait;

    case ID                 = 'id';
    case ORDER_ID           = 'order_id';
    case TRANSACTION_NUMBER = 'transaction_number';
    case AMOUNT             = 'amount';
    case PAID_THROUGH       = 'paid_through';
    case CREATED_AT         = 'created_at';

    public static function labels(): array
    {
        return [
            self::ID->value                 => __('enum_labels.transaction_fields.id'),
            self::ORDER_ID->value           => __('enum_labels.transaction_fields.order_id'),
            self::TRANSACTION_NUMBER->value => __('enum_labels.transaction_fields.transaction_number'),
            self::AMOUNT->value             => __('enum_labels.transaction_fields.amount'),
            self::PAID_THROUGH->value       => __('enum_labels.transaction_fields.paid_through'),
            self::CREATED_AT->value         => __('enum_labels.transaction_fields.created_at'),
        ];
    }
}
