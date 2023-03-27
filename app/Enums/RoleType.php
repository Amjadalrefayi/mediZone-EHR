<?php

namespace App\Enums;


use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

/**
 * @method static static SUPER_ADMIN()
 */
final class RoleType extends Enum
{
    const SUPER_ADMIN = 'SUPER_ADMIN';

    public static function getDescription($value): string
    {
        return Str::headline($value);
    }
}
