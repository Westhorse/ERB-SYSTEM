<?php

namespace Modules\Warehouse\Transformers\Api\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDeterminantNameResource extends JsonResource
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
                'id'            => $this->id,
                'name'          => $nameTrans[$key],
            ];
    }
}
