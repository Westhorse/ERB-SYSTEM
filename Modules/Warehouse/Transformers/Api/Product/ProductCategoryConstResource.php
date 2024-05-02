<?php

namespace Modules\Warehouse\Transformers\Api\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryConstResource extends JsonResource
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
            'cost_way' => $this['cost_way'],
            'product_type' => $this['product_type'],
            'apply_tax' => $this['apply_tax'],
            'purchase_disc_type' => $this['purchase_disc_type'],
            'purchase_disc_amount_type' => $this['purchase_disc_amount_type'],
            'sale_disc_type' => $this['sale_disc_type'],
            'sale_disc_amount_type' => $this['sale_disc_amount_type'],
        ];
    }
}

