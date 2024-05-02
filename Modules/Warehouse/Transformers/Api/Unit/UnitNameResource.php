<?php

namespace Modules\Warehouse\Transformers\Api\Unit;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources;
use App\Http\Resources\NameResource;

class UnitNameResource extends JsonResource
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

            'main_unit_name' => $this->productUnit->name ?? '',
            'main_unit_id' => $this->productUnit->id ?? '',

            'units'   =>  NameResource::collection($this->units),
        ];
    }
}
