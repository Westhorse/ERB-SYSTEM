<?php

namespace Modules\Warehouse\Transformers\Api\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductUnitNameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $name = 'name_' . app()->getLocale();
        return [
            'unit_id'        => $this->unit_id ?? '',
            'name' => $this->$name  ?? '',
            'name_ar' => $this->name_ar ?? '',
            'name_en' => $this->name_en ?? '',
        ];
    }
}
