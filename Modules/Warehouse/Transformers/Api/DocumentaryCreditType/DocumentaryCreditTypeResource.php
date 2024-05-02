<?php

namespace Modules\Warehouse\Transformers\Api\DocumentaryCreditType;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentaryCreditTypeResource extends JsonResource
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
        $nameKey = fetchLangFromInputFields($nameTrans);

        return [
            'id'    => $this->id,
            'name'  => $request->header('index') == true ? $nameTrans[$nameKey] : $nameTrans,
            'code'  => $this->code,

            'shipping_type'         => (string)$this->shipping_type,
            'shipping_policy_id'    => $this->shipping_policy_id,

            'credit_ref_bill_type_id'   => $this->credit_ref_bill_type_id,
            'shipping_bill_type_id'     => $this->shipping_bill_type_id,
            'receive_bill_type_id'      => $this->receive_bill_type_id,
            'created_at'                => $this->created_at->format('d/m/Y')
        ];
    }
}
