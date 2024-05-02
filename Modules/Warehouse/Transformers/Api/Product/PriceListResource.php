<?php

namespace Modules\Warehouse\Transformers\Api\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceListResource extends JsonResource
{
     public static $wrap = 'data';
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
            'name' => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'code' => $this->code ?? '',
            'start_date' => $this->start_date ?? '',
            'end_date' => $this->end_date ?? '',
            'is_active' => $this->is_active ?? '',
            'priceListsDetail' => PriceListsDetailResource::collection($this->priceListsDetail),
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
