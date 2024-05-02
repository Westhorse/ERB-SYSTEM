<?php

namespace Modules\Common\Transformers\Api\Unit;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitNameResource extends JsonResource
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
        $name = 'name_' . app()->getLocale();
        return [
            'id'        => $this->id,
            'name_ar'   => $this->name_ar ?? '',
            'name_en'   => $this->name_en ?? '',
            'name'      => $this->$name,
        ];
    }
}
