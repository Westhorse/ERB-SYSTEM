<?php

namespace Modules\POS\Transformers\Api\PointSection;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class PointSectionValueResource extends JsonResource
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
            'id' => $this->id,
            'section_from' => $this->section_from  ?? '',
            'section_to' => $this->section_to ?? '',
            'point_value' => $this->point_value ?? '',
            // 'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
