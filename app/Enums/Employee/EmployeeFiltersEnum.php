<?php

namespace App\Enums\Employee;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

enum EmployeeFiltersEnum: string implements BaseEnumInterface
{
    use BaseEnumTrait;

    case ID           = 'id';
    case NAME         = 'name';
    case EMAIL        = 'email';
    case PHONE        = 'phone';
    case DESIGNATION  = 'designation';
    case SALARY       = 'salary';
    case NID          = 'nid';
    case JOINING_DATE = 'joining_date';
    case CREATED_AT   = 'created_at';

    public static function labels(): array
    {
        return [
            self::ID->value           => __('enum_labels.employee_fields.id'),
            self::NAME->value         => __('enum_labels.employee_fields.name'),
            self::EMAIL->value        => __('enum_labels.employee_fields.email'),
            self::PHONE->value        => __('enum_labels.employee_fields.phone'),
            self::DESIGNATION->value  => __('enum_labels.employee_fields.designation'),
            self::SALARY->value       => __('enum_labels.employee_fields.salary'),
            self::NID->value          => __('enum_labels.employee_fields.nid'),
            self::JOINING_DATE->value => __('enum_labels.employee_fields.joining_date'),
            self::CREATED_AT->value   => __('enum_labels.employee_fields.created_at'),
        ];
    }
}
