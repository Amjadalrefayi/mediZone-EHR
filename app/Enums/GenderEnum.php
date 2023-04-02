<?php

namespace App\Enums;


use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

final class GenderEnum extends Enum
{
    const MALE = 1;

    const FEMALE = 2;

    const OTHER = 3;

    const UNKNOWN = 4;

    public static function getDescription($value): string
    {
        return Str::headline($value);
    }
}
