<?php

namespace Modules\Common\Transformers\Api\Bills;

use Illuminate\Http\Resources\Json\JsonResource;

class BillPaymentTermResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
