<?php

namespace App\Http\API\V1\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['max:255'],
            'description' => ['max:255'],
            'active' => ['boolean']
        ];
    }
}
