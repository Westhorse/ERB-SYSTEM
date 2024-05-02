<?php

namespace Modules\Common\Transformers\Api\BillType;

use Illuminate\Http\Resources\Json\JsonResource;

class BillTypeDetailForSettingsResource extends JsonResource
{

    public static $wrap = 'data';
    public $preserveKeys = true;


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
            'label' => $this['label'],
            'bill_type_default_id' => $this['bill_type_default_id'],
            'bill_type_user_setting_id' => $this['bill_type_user_setting_id'],
            'account_id' => $this['account_id'],
            'opposite_account_id' => $this['opposite_account_id'],
            'payment_type' => $this['payment_type'],
        ];
    }
}
