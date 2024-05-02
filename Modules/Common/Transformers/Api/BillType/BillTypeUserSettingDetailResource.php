<?php

namespace Modules\Common\Transformers\Api\BillType;

use Illuminate\Http\Resources\Json\JsonResource;

class BillTypeUserSettingDetailResource extends JsonResource
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
        $labelTrans = $this->translations['label'];
        $key = fetchLangFromInputFields($labelTrans);

        return [
            'id' => $this->id,
            'label'  => $request->header('index') == true ? $labelTrans[$key] : $labelTrans,
            'bill_type_user_setting_id' => $this->	bill_type_user_setting_id ,
            'account_id' => $this->account_id,
            'opposite_account_id' => $this->opposite_account_id,
            'payment_type' => $this->payment_type,
            // 'created_at'    => $this->created_at->format('d/m/y'),
        ];
    }
}



