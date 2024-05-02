<?php

namespace Modules\Warehouse\Transformers\Api\Warehouse;

use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
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
        $key = fetchLangFromInputFields($nameTrans);

        $nameTransdesc = $this->translations['notes'];
        $keydesc = fetchLangFromInputFields($nameTransdesc);

        $nameTransaddress = $this->translations['address'];
        $keydesc = fetchLangFromInputFields($nameTransaddress);
        return [
            'id' => $this->id,
            'name' => $request->header('index') == true ? $nameTrans[$key] ?? [] : $nameTrans,
            'address' => $request->header('index') == true ? $nameTransaddress[$keydesc] ?? [] : (object)$nameTransaddress,
            'notes' => $request->header('index') == true ? $nameTransdesc[$keydesc] ?? [] : (object)$nameTransdesc,
            'lat' => $this->lat ?? '',
            'long' => $this->long ?? '',
            'in_bill_type_id' => $this->in_bill_type_id ?? '',
            'out_bill_type_id' => $this->out_bill_type_id ?? '',
            'code' => $this->code ?? '',
            'address_map' => $this->address_map ?? '',
            'is_active' => $this->is_active ?? '',
            'effect_in_store_value' => $this->effect_in_store_value ?? '',
            'branches_business_id' => $this->branches_business_id ?? '',
            'parent_id' => $this->parent_id ?? '',
            'warehouse_keeper_id' => $this->warehouse_keeper_id ?? '',
            'warehouse_keeper' => $this->warehouse_keeper ?? '',
            'driver_id' => $this->driver_id,
            'fp_account_id' => $this->fp_account_id,
            'lp_account_id' => $this->lp_account_id,
            // 'children'=> ChildrenResource::collection($this->children),
            // 'uniqueId' =>  random_int(100, 100000000),
            'created_at' => $this->created_at->format('d/m/Y')

        ];
    }
}
