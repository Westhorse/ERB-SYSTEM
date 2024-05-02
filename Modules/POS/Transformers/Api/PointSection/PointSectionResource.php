<?php

namespace Modules\POS\Transformers\Api\PointSection;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class PointSectionResource extends JsonResource
{
   // public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'setting'=>$this['setting'] ?? '',
            'value'=> PointSectionValueResource::collection($this['value']) ?? '',
        ];
    }
}
