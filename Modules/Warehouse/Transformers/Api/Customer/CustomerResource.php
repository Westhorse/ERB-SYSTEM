<?php

namespace Modules\Warehouse\Transformers\Api\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $nameTrans = $this->translations['name'];
        $addressTrans = $this->translations['address'];
        $key = fetchLangFromInputFields($nameTrans);
        $keyaddress = fetchLangFromInputFields($addressTrans);
        return [
            'id'    => $this->id,
            'code'  =>$this->code,
            'name'  => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'address'   => $request->header('index') == true ? $addressTrans[$keyaddress] ?? [] : (object)$addressTrans,

            'telephone' => $this->telephone ?? '',
            'fax_number' => $this->fax_number ?? '',
            'tax_number' => $this->tax_number ?? '',
            'is_active' => $this->is_active ?? '',
            'price_list_id' => $this->price_list_id ?? '',
            'account_id' => $this->account_id ?? '',
           // 'account' => $this->account ? $this->account->$name : '',
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
