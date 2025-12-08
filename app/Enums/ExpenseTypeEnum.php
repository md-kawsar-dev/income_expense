<?php

namespace App\Enums;

enum ExpenseTypeEnum: string
{
    case NEED = 'Need';
    case WANT = 'Want';
    case SAVINGS = 'Savings';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
