<?php

namespace App\Enums\Customer;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

enum CustomerFiltersEnum: string implements BaseEnumInterface
{
    use BaseEnumTrait;

    case ID         = 'id';
    case NAME       = 'name';
    case EMAIL      = 'email';
    case PHONE      = 'phone';
    case CREATED_AT = 'created_at';

    public static function labels(): array
    {
        return [
            self::ID->value         => __('enum_labels.customer_fields.id'),
            self::NAME->value       => __('enum_labels.customer_fields.name'),
            self::EMAIL->value      => __('enum_labels.customer_fields.email'),
            self::PHONE->value      => __('enum_labels.customer_fields.phone'),
            self::CREATED_AT->value => __('enum_labels.customer_fields.created_at'),
        ];
    }
}
