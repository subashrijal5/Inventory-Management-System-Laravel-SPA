<?php

namespace App\Enums\User;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

enum UserFiltersEnum: string implements BaseEnumInterface
{
    use BaseEnumTrait;

    case ID                = 'id';
    case NAME              = 'name';
    case EMAIL             = 'email';
    case EMAIL_VERIFIED_AT = 'email_verified_at';
    case CREATED_AT        = 'created_at';

    public static function labels(): array
    {
        return [
            self::ID->value                => __('enum_labels.user_fields.id'),
            self::NAME->value              => __('enum_labels.user_fields.name'),
            self::EMAIL->value             => __('enum_labels.user_fields.email'),
            self::EMAIL_VERIFIED_AT->value => __('enum_labels.user_fields.email_verified_at'),
            self::CREATED_AT->value        => __('enum_labels.user_fields.created_at'),
        ];
    }
}
