<?php

namespace Modules\Common\Transformers\Api\BillType;

use Illuminate\Http\Resources\Json\JsonResource;

class BillTypeSettingsResource extends JsonResource
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
            'id' => $this['id'],
            'user_id' => $this['user_id'],
            'warehouse_id' => $this['warehouse_id'],
            'employee_id' => $this['employee_id'],
            'cost_center_id' => $this['cost_center_id'],
            'project_id' => $this['project_id'],
            'discount_account_id' => $this['discount_account_id'],
            'opposite_discount_account_id' => $this['opposite_discount_account_id'],
            'reference_id' => $this['reference_id'],
            'pos_id' => $this['pos_id'],
            'payment_type' => $this['payment_type'],
            'default_price' => $this['default_price'],
            'detail' => $this['detail'] != '' ? new BillTypeDetailForSettingsResource($this['detail']) : '',
        ];
    }
}
