<?php

namespace App;

trait EnumHelper
{
    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}