<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection as BaseResourceCollection;

class ResourceCollection extends BaseResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $modelName = get_class($this->resource[0]);
        $model = new $modelName;

        return [
            'type' => $model->type,
            'data' => ResourceObjectCollection::collection($this->collection),
            'links' => [
                'self' => route('api.v1.'. $model->type .'.index')
            ],
        ];
    }
}
