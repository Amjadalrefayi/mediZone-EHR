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

    //User
    const INDEX_USER = 'INDEX_USER';

    const SHOW_USER = 'SHOW_USER';

    const STORE_USER = 'STORE_USER';

    const UPDATE_USER = 'UPDATE_USER';

    const DELETE_USER = 'DELETE_USER';

    const SHOW_USER_ROLE = 'SHOW_USER_ROLE';

    const EDIT_USER_ROLE = 'EDIT_USER_ROLE';

    //Role
    const INDEX_ROLE = 'INDEX_ROLE';

    const SHOW_ROLE = 'SHOW_ROLE';

    const STORE_ROLE = 'STORE_ROLE';

    const UPDATE_ROLE = 'UPDATE_ROLE';

    const DELETE_ROLE = 'DELETE_ROLE';

    const SHOW_ROLE_PERMISSION = 'SHOW_ROLE_PERMISSION';

    const EDIT_ROLE_PERMISSION = 'EDIT_ROLE_PERMISSION';

    //Permission
    const SHOW_PERMISSIONS = 'SHOW_PERMISSIONS';

    const UPDATE_USER_PERMISSIONS = 'UPDATE_USER_PERMISSIONS';

    // Language
    const SHOW_LANGUAGE = 'SHOW_LANGUAGE';

    const STORE_LANGUAGE = 'STORE_LANGUAGE';

    const UPDATE_LANGUAGE = 'UPDATE_LANGUAGE';

    const DELETE_LANGUAGE = 'DELETE_LANGUAGE';

    const STORE_USER_LANGUAGE = 'STORE_USER_LANGUAGE';

    const STORE_ORGANIZATION = 'STORE_ORGANIZATION';

    const SHOW_ORGANIZATION = 'SHOW_ORGANIZATION';

    const UPDATE_ORGANIZATION = 'UPDATE_ORGANIZATION';

    const DELETE_ORGANIZATION = 'DELETE_ORGANIZATION';

    const STORE_ORGANIZATION_TYPE = 'STORE_ORGANIZATION_TYPE';



    public static function getDescription($value): string
    {
        return Str::headline($value);
    }
}
