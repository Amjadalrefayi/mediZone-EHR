<?php

namespace App\Http\Resources\Language;

use App\Models\Language;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Language
 **/
class LanguageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
        ];
    }
}
