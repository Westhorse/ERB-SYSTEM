<?php

namespace Modules\POS\Transformers\Api\Cashier;

use Illuminate\Http\Resources\Json\JsonResource;

class CashierNameResource extends JsonResource
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
