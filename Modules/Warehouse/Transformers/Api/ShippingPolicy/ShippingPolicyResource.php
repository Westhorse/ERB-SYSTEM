<?php

namespace Modules\Warehouse\Transformers\Api\ShippingPolicy;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingPolicyResource extends JsonResource
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
        $discriptionTrans = $this->translations['discription'];
        $key = fetchLangFromInputFields($nameTrans);
        $keyDiscription = fetchLangFromInputFields($discriptionTrans);
    
        return [
            'id'            => $this->id,
            'code'          => $this->code,
            'name'          => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'discription'   => $request->header('index') == true ? $discriptionTrans[$keyDiscription] ?? [] : (object)$discriptionTrans,
            'is_active'     => $this->is_active,
            'created_at'    => $this->created_at->format('d/m/Y')
        ];
    }
}
  