<?php

namespace Modules\POS\Transformers\Api\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    public static $wrap = 'data';

    // public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $nameTrans      = $this->translations['name'];
        $workFieldTrans = $this->translations['work_field'];
        $addressTrans   = $this->translations['address'];

        $key            = fetchLangFromInputFields($nameTrans);
        $keyWorkField   = fetchLangFromInputFields($workFieldTrans);
        $keyAddress     = fetchLangFromInputFields($addressTrans);

        return [
            'id'                => $this->id,
            'code'              => $this->code,
            'name'              => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'work_field'        => $request->header('index') == true ? $workFieldTrans[$keyWorkField] ?? [] : (object)$workFieldTrans,
            'address'           => $request->header('index') == true ? $addressTrans[$keyAddress] ?? [] : (object)$addressTrans,
            'telephone'         => $this->telephone,
            'mobile'            => $this->mobile,
            'email'             => $this->email,
            'nationality_id'    => $this->nationality_id,
            'is_active'         => $this->is_active,
            'created_at'        => $this->created_at->format('d/m/Y')
        ];
    }
}
