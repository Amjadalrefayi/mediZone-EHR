<?php

namespace App\Enums;


use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

final class MaritalStatus extends Enum
{
    const SINGLE = 1;

    const MARRIED = 2;

    const DIVORCED = 3;

    const WIDOW = 4;

    public static function getDescription($value): string
    {
        return Str::headline($value);
    }
}
