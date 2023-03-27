<?php

namespace App\Enums;


use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

/**
 *
 */
final class PermissionType extends Enum
{
    const DASHBOARD_ACCESS = 'DASHBOARD_ACCESS';
    public static function getDescription($value): string
    {
        return Str::headline($value);
    }
}
