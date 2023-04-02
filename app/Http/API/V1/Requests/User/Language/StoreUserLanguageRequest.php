<?php

namespace App\Http\API\V1\Requests\User\Language;

use App\Models\Language;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserLanguageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', Rule::exists(User::class, 'id')],
            'language_id' => ['required', Rule::exists(Language::class, 'id')],
            'preferred' => ['required', 'in:0,1'],
        ];
    }
}
