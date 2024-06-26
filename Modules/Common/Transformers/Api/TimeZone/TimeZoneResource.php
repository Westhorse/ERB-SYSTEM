<?php

namespace Modules\Common\Transformers\Api\TimeZone;

use Illuminate\Http\Resources\Json\JsonResource;

class TimeZoneResource extends JsonResource
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

                'id'           => $this->id,
                'name'         => $this->name,

                'diff'         => $this->diff,
                'is_active'    => $this->is_active,

                'created_at'   => $this->created_at->format('d/m/Y')
        ];
    }
}
