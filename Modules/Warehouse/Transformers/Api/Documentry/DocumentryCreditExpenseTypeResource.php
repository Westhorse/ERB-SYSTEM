<?php

namespace Modules\Warehouse\Transformers\Api\Documentry;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentryCreditExpenseTypeResource extends JsonResource
{
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
            'code'=>$this->code ?? '',
            'name'=> $request->header('index') == true ? $this->name : $this->translations['name'],
            'cost_effect' => $this->cost_effect ?? '',
            'cost_distribution' => $this->cost_distribution ?? '',
            'generate_entry' => $this->generate_entry ?? '',
            'tax_percent' => $this->tax_percent ?? '',
            'auto_entry_posting' => $this->auto_entry_posting ?? '',
            'match_voucher_value' => $this->match_voucher_value ?? '',
            'repeate_voucher' => $this->repeate_voucher ?? '',
            'code_by_user' => $this->code_by_user ?? '',
            'taxable' => $this->taxable ?? '',
            'default_account_Id' => $this->default_account_Id  ?? '',
            'tax_account_id' => $this->tax_account_id   ?? '',
            'opposite_account_id' => $this->opposite_account_id    ?? '',
            'shippingPolicy' => $this->shippingPolicy->map->pivot ?? '',
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
