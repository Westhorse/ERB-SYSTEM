<?php

namespace Modules\Common\Transformers\Api\BillType;

use Illuminate\Http\Resources\Json\JsonResource;

class BillTypeNameResource extends JsonResource
{
    public static $wrap = 'children';
    

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
                'id'            => $this->id,
                'name'          => $nameTrans[$key],
                'type'          => 'folder',
        ];
    }
}
