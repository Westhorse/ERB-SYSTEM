<?php

namespace Modules\Common\Transformers\Api\Card;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentTypeResource extends JsonResource
{
        public static $wrap = 'data';

//    public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $nameTrans = $this->translations['name'];
        $key = fetchLangFromInputFields($nameTrans);

        return [
            'id' => $this->id,
            'name'  => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'code' => $this->code,
            'dtype' => $this->dtype,
            'follow_renewal' => $this->follow_renewal,
            'days_count' => $this->days_count ?? '',
            'is_active' => $this->is_active ?? '',
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
