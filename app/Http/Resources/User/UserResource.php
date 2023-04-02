<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 **/
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'id_number' => $this->id_number,
            'name' => $this->name,
            'family' => $this->family,
            'prefix' => $this->prefix,
            'suffix' => $this->suffix,
            'marital_status' => $this->marital_status,
            'gender' => $this->gender,
            'type' => $this->type,
            'photo' => $this->photo,
            'deceased' => $this->deceased,
            'birth_date' => $this->birth_date,
            'deceased_date' => $this->deceased_date,
        ];
    }

}
