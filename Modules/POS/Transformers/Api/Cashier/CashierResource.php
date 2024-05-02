<?php

namespace Modules\POS\Transformers\Api\Cashier;

use Illuminate\Http\Resources\Json\JsonResource;
use function request;

class CashierResource extends JsonResource
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
            'code' => $this->code,
            'name' => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
