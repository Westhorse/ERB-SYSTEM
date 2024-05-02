<?php

namespace Modules\Warehouse\Transformers\Api\Warehouse;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Warehouse\Transformers\Api\Product\ProductNamesTreeResource;

class ChildrenResourceTree extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $request->header('index') == true ? $this->name : $this->translations['name'],
            'code' => $this->code ?? '',
            'children'=>  ProductNamesTreeResource::collection($this->products),
        ];

    }
}
