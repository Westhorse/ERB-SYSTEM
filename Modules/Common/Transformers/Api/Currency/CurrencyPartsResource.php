<?php

namespace Modules\Common\Transformers\Api\Currency;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyPartsResource extends JsonResource
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
            'rate'          => $this->rate,
            'disable'       => $this->is_active ? false : true,
        ];
    }
}
