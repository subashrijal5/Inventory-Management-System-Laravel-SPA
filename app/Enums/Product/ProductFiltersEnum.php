<?php

namespace App\Enums\Product;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

enum ProductFiltersEnum: string implements BaseEnumInterface
{
    use BaseEnumTrait;

    case KEYWORD        = 'keyword';
    case ID             = 'id';
    case CATEGORY_ID    = 'category_id';
    case SUPPLIER_ID    = 'supplier_id'; // nullable
    case NAME           = 'name';
    case PRODUCT_NUMBER = 'product_number';
    case PRODUCT_CODE   = 'product_code'; // nullable
    case BUYING_PRICE   = 'buying_price';
    case SELLING_PRICE  = 'selling_price';
    case BUYING_DATE    = 'buying_date'; // nullable
    case UNIT_TYPE_ID   = 'unit_type_id';
    case QUANTITY       = 'quantity';
    case QUANTITIES     = 'quantities';
    case STATUS         = 'status';
    case CREATED_AT     = 'created_at';

    public static function labels(): array
    {
        return [
            self::KEYWORD->value        => __('enum_labels.product_fields.keyword'),
            self::ID->value             => __('enum_labels.product_fields.id'),
            self::CATEGORY_ID->value    => __('enum_labels.product_fields.category_id'),
            self::SUPPLIER_ID->value    => __('enum_labels.product_fields.supplier_id'),
            self::PRODUCT_NUMBER->value => __('enum_labels.product_fields.product_number'),
            self::NAME->value           => __('enum_labels.product_fields.name'),
            self::PRODUCT_CODE->value   => __('enum_labels.product_fields.product_code'),
            self::BUYING_PRICE->value   => __('enum_labels.product_fields.buying_price'),
            self::SELLING_PRICE->value  => __('enum_labels.product_fields.selling_price'),
            self::BUYING_DATE->value    => __('enum_labels.product_fields.buying_date'),
            self::UNIT_TYPE_ID->value   => __('enum_labels.product_fields.unit_type_id'),
            self::QUANTITIES->value     => __('enum_labels.product_fields.quantities'),
            self::STATUS->value         => __('enum_labels.product_fields.status'),
            self::CREATED_AT->value     => __('enum_labels.product_fields.created_at'),
        ];
    }
}
