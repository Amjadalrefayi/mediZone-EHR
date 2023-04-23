<?php

namespace App\Http\API\V1\Requests\Organization\type;

use App\Models\Code;
use App\Models\Organization;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrganizationType extends FormRequest
{
    public function rules(): array
    {
        return [
            'organization_id' => [Rule::exists(Organization::class, 'id')],
            'code_id' => [ Rule::exists(Code::class, 'id')],
            'description' => [ 'max:255'],
        ];
    }
}
