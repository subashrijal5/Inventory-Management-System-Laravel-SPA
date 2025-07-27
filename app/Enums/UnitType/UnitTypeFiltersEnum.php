<?php

namespace App\Enums\UnitType;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

enum UnitTypeFiltersEnum: string implements BaseEnumInterface
{
    use BaseEnumTrait;

    case ID         = 'id';
    case NAME       = 'name';
    case SYMBOL     = 'symbol';
    case CREATED_AT = 'created_at';

    public static function labels(): array
    {
        return [
            self::ID->value         => __('enum_labels.unit_type_fields.id'),
            self::NAME->value       => __('enum_labels.unit_type_fields.name'),
            self::SYMBOL->value     => __('enum_labels.unit_type_fields.symbol'),
            self::CREATED_AT->value => __('enum_labels.unit_type_fields.created_at'),
        ];
    }
}
