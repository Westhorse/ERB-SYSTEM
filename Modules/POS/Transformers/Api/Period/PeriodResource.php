<?php

namespace Modules\POS\Transformers\Api\Period;

use Illuminate\Http\Resources\Json\JsonResource;

class PeriodResource extends JsonResource
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
            'account_id' => $this->account_id,
            'branch_id' => $this->branch_id,
            'name' => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'from_time' => $this->from_time,
            'to_time' => $this->to_time,
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
