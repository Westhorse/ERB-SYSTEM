<?php

namespace Modules\Warehouse\Transformers\Api\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
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
        $notesTrans = $this->translations['notes'];
        $key = fetchLangFromInputFields($nameTrans);
        $keyNotes = fetchLangFromInputFields($notesTrans);

        return [
            'id'        => $this->id,
            'name'      => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'notes'     => $request->header('index') == true ? $notesTrans[$keyNotes] ?? [] : (object)$notesTrans,
            'code'      => $this->code,
            'parent_id' => $this->parent_id,
            'branch_id' => $this->branch_id,
            'unit_id'   => $this->unit_id,

            'cost_way'                  => $this->cost_way,
            'apply_tax'                 => $this->apply_tax,
            'product_type'              => $this->product_type,
            'commission_type'           => $this->commission_type,
            'purchase_disc_type'        => $this->purchase_disc_type,
            'purchase_disc_amount_type' => $this->purchase_disc_amount_type,
            'sale_disc_type'            => $this->sale_disc_type,
            'sale_disc_amount_type'     => $this->sale_disc_amount_type,
            'purchase_disc_amount'      => $this->purchase_disc_amount,
            'cost_price_effect'         => $this->cost_price_effect,
            'buy_free_percent'          => $this->buy_free_percent,
            'sale_disc_amount'          => $this->sale_disc_amount,
            'sale_free_percent'         => $this->sale_free_percent,
            'cash_commission'           => $this->cash_commission,
            'later_commission'          => $this->later_commission,

            'cost_way'          => $this->cost_way ?? null,
            'apply_tax'         => $this->apply_tax ?? null,
            'product_type'      => $this->product_type ?? null,
            'commission_type'   => $this->commission_type ?? null,
            'purchase_disc_type' => $this->purchase_disc_type ?? null,
            'purchase_disc_amount_type' => $this->purchase_disc_amount_type ?? null,
            'sale_disc_type' => $this->sale_disc_type ?? null,
            'sale_disc_amount_type' => $this->sale_disc_amount_type ?? null,

            'purchase_disc_amount'  => $this->purchase_disc_amount ?? null,
            'cost_price_effect'     => $this->cost_price_effect ?? null,
            'buy_free_percent'      => $this->buy_free_percent ?? null,
            'sale_disc_amount'      => $this->sale_disc_amount ?? null,
            'sale_free_percent'     => $this->sale_free_percent ?? null,

            'cash_commission' => $this->cash_commission ?? null,
            'later_commission' => $this->later_commission ?? null,

            'accountsObject' => [
                'sales_account_id'      => $this->sales_account_id ?? null,
                'resales_account_id'    => $this->resales_account_id ?? null,
                'purchase_account_id'   => $this->purchase_account_id ?? null,
                'repurchase_account_id' => $this->repurchase_account_id ?? null,
                'cost_account_id'       => $this->cost_account_id ?? null,
                'stock_account_id'      => $this->stock_account_id ?? null,
            ],

            'type'          => 'product-categories' ?? null,
            'is_active'     => $this->is_active ?? null,
            'taxes'         => $this->taxes->pluck('id')->toArray() ?? null,
            'children'      => ProductNameResource::collection($this->products) ?? null,
            'created_at'    => isset($this->created_at) ? $this->created_at->format('d/m/Y')  : null
        ];
    }
}
