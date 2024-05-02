<?php

namespace Modules\Warehouse\Transformers\Api\TransferItemsVoucher;

use Illuminate\Http\Resources\Json\JsonResource;

class TransferItemsVoucherDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
