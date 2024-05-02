<?php

namespace Modules\Warehouse\Transformers\Api\Tax;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxDetailResource extends JsonResource
{
    // public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->tax->name,
            'amount_type' => $this->amount_type,
            'amount_value' => $this->amount_value,
            // 'tax_id' => $this->tax_id,
            // 'country_id' => $this->country_id,
            // 'impact' => $this->impact,
            // 'start_date' => $this->start_date,
            // 'end_date' => $this->end_date,
            // 'sales_tax_account_id' => $this->sales_tax_account_id,
            // 'purchase_tax_account_id' => $this->purchase_tax_account_id,
            // 'created_at' => $this->created_at->format('d/m/y')
        ];
    }
}
