<?php

namespace Modules\Warehouse\Transformers\Api\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceListsDetailResource extends JsonResource
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
            "priceList_id"  => $this->priceList_id,
            "product_id"  => $this->product_id,
            // "product_name" => $this->product,
            "unit_id"  => $this->unit_id,
            // "unit_id"  => $this->unit,
            "price" => $this->price,
            'created_at' => $this->created_at
        ];
    }
}
