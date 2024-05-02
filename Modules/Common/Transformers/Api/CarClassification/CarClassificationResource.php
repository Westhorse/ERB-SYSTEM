<?php

namespace Modules\Common\Transformers\Api\CarClassification;

use Illuminate\Http\Resources\Json\JsonResource;

class CarClassificationResource extends JsonResource
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
            'id' => $this->id,
            'name' => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'code' => $this->code,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    } 
}
