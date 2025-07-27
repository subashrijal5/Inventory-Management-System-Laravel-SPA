<?php

namespace App\Enums\Salary;

use App\Enums\BaseEnumInterface;
use App\Enums\BaseEnumTrait;

enum SalaryFiltersEnum: string implements BaseEnumInterface
{
    use BaseEnumTrait;

    case ID          = 'id';
    case EMPLOYEE_ID = 'employee_id';
    case AMOUNT      = 'amount';
    case SALARY_DATE = 'salary_date';
    case CREATED_AT  = 'created_at';

    public static function labels(): array
    {
        return [
            self::ID->value          => __('enum_labels.salary_fields.id'),
            self::EMPLOYEE_ID->value => __('enum_labels.salary_fields.employee_id'),
            self::AMOUNT->value      => __('enum_labels.salary_fields.amount'),
            self::SALARY_DATE->value => __('enum_labels.salary_fields.salary_date'),
            self::CREATED_AT->value  => __('enum_labels.salary_fields.created_at'),
        ];
    }
}
