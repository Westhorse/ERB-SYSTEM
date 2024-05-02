<?php

namespace Modules\Warehouse\Transformers\Api\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class DeterminantsDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $nameTrans = $this->translations['name'];
        $key = fetchLangFromInputFields($nameTrans);

        return [
            'id' => $this->id,
            'name' => $request->header('index') == true ? $nameTrans[$key] ?? []: $nameTrans,
            'is_default' => $this->is_default ?? '',
            "determinant_id"  => $this->determinant_id,
            'created_at' => $this->created_at
        ];
    }
}
