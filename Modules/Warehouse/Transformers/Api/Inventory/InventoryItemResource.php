<?php

namespace Modules\Warehouse\Transformers\Api\Inventory;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $remarksTrans = $this->translations['remarks'];
        $remarksKey = fetchLangFromInputFields($remarksTrans);

        return [
            "id" => $this->id,
            "inventory_id" => $this->inventory_id,
            "product_id" => $this->product_id,
            "product_qty" => $this->product_qty,
            'remarks'          => $request->header('index') == true ? $remarksTrans[$remarksKey] ?? "" : $remarksTrans,
        ];
    }
}
