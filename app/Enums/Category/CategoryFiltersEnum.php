<?php

namespace App\Enums\Category;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

enum CategoryFiltersEnum: string implements BaseEnumInterface
{
    use BaseEnumTrait;

    case ID         = 'id';
    case NAME       = 'name';
    case CREATED_AT = 'created_at';

    public static function labels(): array
    {
        return [
            self::ID->value         => __('enum_labels.category_fields.id'),
            self::NAME->value       => __('enum_labels.category_fields.name'),
            self::CREATED_AT->value => __('enum_labels.category_fields.created_at'),
        ];
    }
}
