<?php

namespace Modules\FixedAsset\Transformers\Api\AssetTransfer;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetTransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $notesTrans = $this->translations['remarks'];
        $notesKey = fetchLangFromInputFields($notesTrans);
        return [
            'id' => $this->id,
            'remarks' => $request->header('index') == true ? $notesTrans[$notesKey] ?? [] : (object)$notesTrans,
            'product_id' => $this->product_id,
            'order_number' => $this->order_number,
            'order_date' => $this->order_date,
            'user_id' => $this->user_id,
            'user_name' => $this->tempUsers->name,
            'old_status_id' => $this->old_status_id,
            'old_deprecation_account_id' => $this->old_deprecation_account_id,
            'old_cost_center_id' => $this->old_cost_center_id,
            'current_status_id' => $this->current_status_id,
            'current_cost_center_id' => $this->current_cost_center_id,
            'current_deprecation_account_id' => $this->current_deprecation_account_id,
            'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }
}
