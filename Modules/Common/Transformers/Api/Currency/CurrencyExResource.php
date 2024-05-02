<?php

namespace Modules\Common\Transformers\Api\Currency;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyExResource extends JsonResource
{
    public static $wrap = 'exchanges';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'exchanges'  => CurrencyExchangeResource::collection($this->currencyExchange),
        ];
    }
}
