<?php

namespace App\Http\API\V1\Requests\Language;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLanguageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['max:255'],
            'code' => ['max:255', Rule::unique(Language::class, 'code')],
        ];
    }

}
