<?php

namespace App\Http\API\V1\Requests\User;

use App\Enums\GenderEnum;
use App\Enums\MaritalStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'id_number' => ['required', 'max:255', Rule::unique(User::class, 'id_number')],
            'password' => ['required', 'max:255'],
            'type' => ['required', Rule::in(UserType::getValues())],
            'name' => ['required', 'max:255'],
            'family' => ['required', 'max:255'],
            'prefix' => ['required', 'max:255'],
            'suffix' => ['required', 'max:255'],
            'marital_status' => ['required', Rule::in(MaritalStatus::getValues())],
            'gender' => ['required', Rule::in(GenderEnum::getValues())],
            'photo' => ['required', 'image'],
            'birth_date' => ['required', 'date_format:Y-m-d H:i'],
            'deceased' => ['in:0,1'],
            'deceased_date' => $deceasedDateRule,
        ];
    }

}
