<?php

namespace Modules\Warehouse\Transformers\Api\Warehouse;

use Illuminate\Http\Resources\Json\JsonResource;

class ChildrenResource extends JsonResource
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
            'uniqueId' => random_int(100, 100000000),
            'name' => $request->header('index') == true ? $this->name : $this->translations['name'],
            'code' => $this->code ?? '',
            'is_active' => $this->is_active ?? '',
            'parent_id' => $this->parent_id ?? '',
            'children'=>ChildrenResource::collection($this->children),
            'created_at' => $this->created_at->format('d/m/Y')

        ];
    }
}
