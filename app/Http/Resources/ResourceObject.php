<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResourceObject extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'type' => $this->type,
            'id' => (string) $this->getRouteKey(),
            'attributes' => $this->fields(),
            'links' => [
                'self' => route('api.v1.'. $this->type .'.index')
            ]
        ];
    }
}
