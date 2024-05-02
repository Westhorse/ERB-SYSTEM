<?php

namespace Modules\Common\Transformers\Api\Area;

use Modules\Common\Transformers\Api\Currency\CurrencyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
{

    public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $nameTrans = $this->translations['name'];
        $key = fetchLangFromInputFields($nameTrans);

        return [
            'id'            => $this->id,
            'code'          => $this->code,
            'name'          => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'currency'      => new CurrencyResource($this->currency),
            'currency_id'   => $this->currency_id,
            'time_zone_id'  => $this->time_zone_id,
            'time_zone'     => $this->timeZone,
            'is_active'     => $this->is_active,
            'created_at'    => $this->created_at->format('d/m/y'),
        ];
    }

}
