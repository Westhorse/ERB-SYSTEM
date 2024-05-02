<?php

namespace Modules\Warehouse\Transformers\Api\Offer;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferDetailResource extends JsonResource
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
        return [
            'id' => $this->id,
            'offer_id' => $this->offer_id,
            'kind' => $this->kind,
            'product_id' => $this->product_id,
            'warehouse_id' => $this->warehouse_id,
            'required_qty' => $this->required_qty,
            'offer_qrt' => $this->offer_qrt,
            'max_offer_qty' => $this->max_offer_qty,
            'item_price' => $this->item_price,
            'discount_percent' => $this->discount_percent,
            'free_qty' => $this->free_qty,
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
