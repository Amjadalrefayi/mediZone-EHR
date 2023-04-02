<?php

namespace App\Http\API\V1\Requests\Role\Permission;


use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam permissionIds int[] List of the permissions Ids.
 */
class EditRolePermissionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'permission_ids' => ['required'],
            'permission_ids.*' => ['exists:permissions,id'],
        ];
    }

    public function bodyParameters()
    {
        return [
//            'title' => [
//                'description' => 'The title of the post.',
//                'example' => 'My First Post',
//            ],
        ];
    }
}
