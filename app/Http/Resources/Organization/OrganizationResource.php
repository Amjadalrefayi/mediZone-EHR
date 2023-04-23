<?php

namespace App\Http\Resources\Organization;

use App\Models\Organization;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Organization
 **/
class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'active'=>$this->active
        ];
    }

}
