<?php

namespace Modules\Common\Transformers\Api\Currency;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
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

        $partTrans = $this->translations['part_name'];
        $key = fetchLangFromInputFields($partTrans);

        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $request->header('index') == true ? $nameTrans[$key] ?? []  : $nameTrans,
            'part_name' => $request->header('index') == true ? $partTrans[$key] ?? '' : (object)$partTrans,

            'symbol' => $this->symbol ?? '',
            'is_active' => $this->is_active ?? '',
            'parts'  => CurrencyPartResource::collection($this->currencyPart),
            'exchanges'  => CurrencyExchangeResource::collection($this->currencyExchange),
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
