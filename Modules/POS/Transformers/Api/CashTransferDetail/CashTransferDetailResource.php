<?php

namespace Modules\POS\Transformers\Api\CashTransferDetail;

use Illuminate\Http\Resources\Json\JsonResource;

class CashTransferDetailResource extends JsonResource
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
            'id'            => $this->id,
            'part_id'       => $this->part_id,
            'part_count'    => $this->part_count,
            'part_rate'     => $this->rate,
            'total_rate'    => $this->totalRate
        ];
    }
}
