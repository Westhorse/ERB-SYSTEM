<?php

namespace Modules\Common\Transformers\Api\Tax;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxResource extends JsonResource
{
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

                'id'           => $this->id,
                'name'         => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
                // 'name_ar'      => $this->name_ar ?? '',
                // 'name_en'      => $this->name_en ?? '',
                // 'name'         =>$this->$name ,
                'code'         => $this->code,
                'is_active'    => $this->is_active,
                'countries'    => $this->countries,
                'created_at'   => $this->created_at->format('d/m/Y')
        ];
    }
}
