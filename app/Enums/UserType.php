<?php

namespace App\Enums;


use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

/**
 * @method static static SUPER_ADMIN()
 */
final class UserType extends Enum
{
    const SUPER_ADMIN = 1;

    const ADMIN = 2;

    const PATIENT = 3;

    const DOCTOR = 4;

    public static function getDescription($value): string
    {
        return Str::headline($value);
    }
}
