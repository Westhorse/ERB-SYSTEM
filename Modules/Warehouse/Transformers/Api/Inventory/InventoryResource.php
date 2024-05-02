<?php

namespace Modules\Warehouse\Transformers\Api\Inventory;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $nameTrans = $this->translations['name'];
        $key = fetchLangFromInputFields($nameTrans);
        $remarksTrans = $this->translations['remarks'];
        $remarksKey = fetchLangFromInputFields($remarksTrans);
        return [
            "id" => $this->id,
            "code" => $this->code,
            'name'          => $request->header('index') == true ? $nameTrans[$key] ?? "" : $nameTrans,
            "inventory_date" => $this->inventory_date,
            "warehouse_id" =>  $this->warehouse_id,
            "currency_id" =>  $this->currency_id,
            "conversion_factor" =>  $this->conversion_factor,
            'remarks'          => $request->header('index') == true ? $remarksTrans[$remarksKey] ?? "" : (object)$remarksTrans,
            "inventory_type" =>  $this->inventory_type,
            "is_approved" =>  $this->is_approved,
            "items" => InventoryItemResource::collection($this->items)
        ];
    }
}
