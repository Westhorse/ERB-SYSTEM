<?php

namespace Modules\Common\Transformers\Api\Currency;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyExchangeResource extends JsonResource
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
            'from_currency_id' =>$this->from_currency_id ?? '',
            'to_currency_id' =>$this->to_currency_id ?? '',
            'exchange_rate' =>$this->exchange_rate ?? '',
            'exchange_date' =>$this->exchange_date ?? '',
           'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
