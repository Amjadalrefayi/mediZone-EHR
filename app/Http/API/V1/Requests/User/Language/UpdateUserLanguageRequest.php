<?php

namespace App\Http\API\V1\Requests\User\Language;

use App\Models\Language;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserLanguageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => [Rule::exists(User::class, 'id')],
            'language_id' => [Rule::exists(Language::class, 'id')],
            'preferred' => ['in:0,1'],
        ];
    }

}
