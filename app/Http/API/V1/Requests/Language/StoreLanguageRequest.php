<?php

namespace App\Http\API\V1\Requests\Language;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLanguageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'code' => ['required', 'max:255', Rule::unique(Language::class, 'code')],
        ];
    }

}
