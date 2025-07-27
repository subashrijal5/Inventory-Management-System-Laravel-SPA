<?php

namespace App\Enums\Product;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

enum ProductStatusEnum: string implements BaseEnumInterface
{
    use BaseEnumTrait;

    case ACTIVE   = 'active';
    case INACTIVE = 'inactive';

    public static function labels(): array
    {
        return [
            self::ACTIVE->value   => __('enum_labels.product_status.active'),
            self::INACTIVE->value => __('enum_labels.product_status.inactive'),
        ];
    }
}
