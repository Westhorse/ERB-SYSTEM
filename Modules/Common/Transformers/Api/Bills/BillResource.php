<?php

namespace Modules\Common\Transformers\Api\Bills;

use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'invoice_total' => $this->invoice_total,
            'invoice_total_tax' => $this->invoice_total_tax,
            'main' => [
                'code' => $this->code,
                'bill_type' => $this->bill_type_id,
                'vendor_bill_no' => $this->vendor_bill_no,
                'bill_version' => $this->bill_version,
                'bill_date' => $this->bill_date,
                'payment_type' => $this->payment_type == 1 ? 'cash' : ($this->payment_type == 2 ? 'credit' : ($this->payment_type == 2 ? 'installment' : '')),
                'paid_amount' => $this->paid_amount,
                'currency' => $this->currency_id,
                'conversion_factor' => $this->conversion_factor,
                'payment_account_id' => $this->payment_account_id,
                'bill_account_id' => $this->bill_account_id,
                'ref_bill_type_id' => $this->ref_bill_type_id,
                'ref_bill_id' => $this->ref_bill_id,
                'supply_date' => $this->supply_date,
                'warehouse_id' => $this->warehouse_id,
                'cost_center_id' => $this->cost_center_id,
                'representative_id' => $this->representative_id,
                'project_id' => $this->project_id,
                'customer_id' => $this->customer_id,
                'supplier_id' => $this->supplier_id,
                'driver_id' => $this->driver_id,
                'car_id' => $this->car_id,
                'shipping_policy_id' => $this->shipping_policy_id,
                'paid_account_id' => $this->paid_account_id,
                'rest_account_id' => $this->rest_account_id,
                'days_count' => $this->days_count,
                'currency_id' => $this->currency_id,
                'trailer_id' => $this->trailer_id,
                'shipping_type' => $this->shipping_type,
                'notes' => $this->translations['notes']
            ],
            'bills_items' =>  BillItemResource::collection($this->items->load('taxes')),
            'bill_effects' => BillEffectResource::collection($this->effects),
            'bill_payment_terms' => BillPaymentTermResource::collection($this->paymentTerms),
        ];
    }
}
