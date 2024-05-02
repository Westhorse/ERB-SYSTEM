<?php

namespace Modules\Common\Transformers\Api\Setting;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $nameTrans = $this->translations['setting_value'];

        $key = fetchLangFromInputFields($nameTrans);


        return [

            'setting_id'           => $this->setting_id,
            'setting_name'  => $this->setting_name ?? '',
            'setting_value'           =>(object) $nameTrans,
            // 'files' =>  $this->settings["15"],
            'created_at'   => $this->created_at->format('d/m/Y')
        ];
    }
}
