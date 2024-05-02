<?php

namespace Modules\Common\Transformers\Api\Nationality;

use Illuminate\Http\Resources\Json\JsonResource;

class NationalityNameResource extends JsonResource
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
            'id'=>$this->id,
            'name'=>$this->$name,
            'name_en'=>$this->name_en,
            'name_ar'=>$this->name_ar,
        ];
    }
}
