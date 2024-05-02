<?php

namespace Modules\Common\Transformers\Api\Area;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $request->header('index') == true ? $this->name : $this->translations['name'],
            'is_active' => $this->is_active,
        ];
    }

}

