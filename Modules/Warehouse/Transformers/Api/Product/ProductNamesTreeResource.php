<?php

namespace Modules\Warehouse\Transformers\Api\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductNamesTreeResource extends JsonResource
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
        $tr = 0;
        return [
            'id'            => $this->id,
            'name'          => $nameTrans[$key],
            'is_product_category'=>  0,
        ];
    }
}
