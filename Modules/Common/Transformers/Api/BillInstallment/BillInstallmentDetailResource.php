<?php

namespace Modules\Common\Transformers\Api\BillInstallment;

use Illuminate\Http\Resources\Json\JsonResource;

class BillInstallmentDetailResource extends JsonResource
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
            'installment_date' => $this->installment_date,
            'installment_value' => $this->installment_value,
            'installment_status' => $this->installment_status,
            'remarks' => $this->remarks,
        ];
    }
}
