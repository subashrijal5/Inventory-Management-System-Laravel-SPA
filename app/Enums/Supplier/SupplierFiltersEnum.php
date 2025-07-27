<?php

namespace App\Enums\Supplier;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

enum SupplierFiltersEnum: string implements BaseEnumInterface
{
    use BaseEnumTrait;

    case ID         = 'id';
    case NAME       = 'name';
    case EMAIL      = 'email';
    case PHONE      = 'phone';
    case SHOP_NAME  = 'shop_name';
    case CREATED_AT = 'created_at';

    public static function labels(): array
    {
        return [
            self::ID->value        => __('enum_labels.supplier_fields.id'),
            self::NAME->value      => __('enum_labels.supplier_fields.name'),
            self::EMAIL->value     => __('enum_labels.supplier_fields.email'),
            self::PHONE->value     => __('enum_labels.supplier_fields.phone'),
            self::SHOP_NAME->value => __('enum_labels.supplier_fields.shop_name'),
            self::CREATED_AT->value => __('enum_labels.supplier_fields.created_at'),
        ];
    }
}
