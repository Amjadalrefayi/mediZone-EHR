<?php

namespace App\Http\API\V1\Requests\User;

use App\Enums\GenderEnum;
use App\Enums\MaritalStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        $deceasedDateRule = ['date_format:Y-m-d H:i'];

        $request = request()->all();
        if (isset($request)) {
            if (isset($request['deceased']))
                if ($request['deceased'] == 1)
                    $deceasedDateRule[] = 'required';
        }
        return [
            'id_number' => ['max:255', Rule::unique(User::class, 'id_number')],
            'password' => ['max:255'],
            'type' => [Rule::in(UserType::getValues())],
            'name' => ['max:255'],
            'family' => ['max:255'],
            'prefix' => ['max:255'],
            'suffix' => ['max:255'],
            'marital_status' => [Rule::in(MaritalStatus::getValues())],
            'gender' => [Rule::in(GenderEnum::getValues())],
            'photo' => ['image'],
            'birth_date' => ['date_format:Y-m-d H:i'],
            'deceased' => ['in:0,1'],
            'deceased_date' => $deceasedDateRule,
        ];
    }
}
