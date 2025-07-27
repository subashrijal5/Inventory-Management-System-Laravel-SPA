<?php

namespace App\Enums\Expense;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

enum ExpenseFiltersEnum: string implements BaseEnumInterface
{
    use BaseEnumTrait;

    case ID           = 'id';
    case NAME         = 'name';
    case AMOUNT       = 'amount';
    case EXPENSE_DATE = 'expense_date';
    case CREATED_AT   = 'created_at';

    public static function labels(): array
    {
        return [
            self::ID->value           => __('enum_labels.expense_fields.id'),
            self::NAME->value         => __('enum_labels.expense_fields.name'),
            self::AMOUNT->value       => __('enum_labels.expense_fields.amount'),
            self::EXPENSE_DATE->value => __('enum_labels.expense_fields.expense_date'),
            self::CREATED_AT->value   => __('enum_labels.expense_fields.created_at'),
        ];
    }
}
