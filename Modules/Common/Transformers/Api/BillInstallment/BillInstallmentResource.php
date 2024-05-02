<?php

namespace Modules\Common\Transformers\Api\BillInstallment;

use Illuminate\Http\Resources\Json\JsonResource;

class BillInstallmentResource extends JsonResource
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
        return [
            'id' => $this->id,
            'bill_id' => $this->bill_id,
            'installment_way' => $this->installment_way,
            'period_start' => $this->period_start,
            'calc_by_hijri' => $this->calc_by_hijri,
            'first_payment' => $this->first_payment,
            'first_payment_date' => $this->first_payment_date,
            'start_date' => $this->start_date,
            'installment_value' => $this->installment_value,
            'installment_count' => $this->installment_count,
            'details' => $this->id,
            "details" => BillInstallmentDetailResource::collection($this->details),
        ];
    }
}
