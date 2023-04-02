<?php

namespace App\Http\API\V1\Requests\Role;


use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['max:255'],
            'description' => 'max:255',
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
