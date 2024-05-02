<?php

namespace Modules\POS\Transformers\Api\CashTransfer;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\POS\Transformers\Api\CashTransferDetail\CashTransferDetailResource;

class CashTransferResource extends JsonResource
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
            'id'                => $this->id,
            'src_user_id'       => $this->src_user_id,
            'sender'            => $this->sender,
            'src_pos_id'        => $this->src_pos_id,
            'src_period_id'     => $this->src_period_id,
            'trans_date'        => $this->trans_date,
            'dest_user_id'      => $this->dest_user_id,
            'receiver'          => $this->receiver,
            'dest_pos_id'       => $this->dest_pos_id,
            'dest_period_id'    => $this->dest_period_id,
            'amount_value'      => $this->amount_value,
            'currency_id'       => $this->currency_id,
            // 'details'           => $request->header('index') == true ? '' : CashTransferDetailResource::collection($this->cashTransferDetailsWithRate),
            'created_at'        => $this->created_at->format('d/m/Y'), 
            'details'           => $request->header('index') == true ? '' : CashTransferDetailResource::collection($this->detailsWithRate),
        ];
    }
}
