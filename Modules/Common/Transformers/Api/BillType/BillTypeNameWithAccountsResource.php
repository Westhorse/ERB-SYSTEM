<?php

namespace Modules\Common\Transformers\Api\BillType;

use Illuminate\Http\Resources\Json\JsonResource;

class BillTypeNameWithAccountsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $nameTrans = $this->translations['name'];
        $key = fetchLangFromInputFields($nameTrans);
        return [
            'id'            => $this->id,
            'name'          => $nameTrans[$key],
            'disable'       => $this->is_active == 1 ? false : true,
            'account_flag'       => $this->account_flag,
            'account_id'       => $this->account_id  != "" ? $this->account_id : null,
        ];
    }
}
