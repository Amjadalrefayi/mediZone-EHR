<?php

namespace App\Http\API\V1\Requests\Organization\type;

use App\Models\Code;
use App\Models\Organization;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
class StoreOrganizationType extends FormRequest
{
    public function rules(): array
    {
        return [
            'organization_id' => ['required', Rule::exists(Organization::class, 'id')],
            'code_id' => ['required', Rule::exists(Code::class, 'id')],
            'description' => ['nullable', 'max:255'],
        ];
    }
}
