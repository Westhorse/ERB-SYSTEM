<?php

namespace Modules\Common\Transformers\Api\Languages;

use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{

    public static $wrap = 'data';
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $nameTrans = $this->translations['name'];
        $key        = fetchLangFromInputFields($nameTrans);
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name'  => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'key' => $this->key,
            'rtl' => $this->rtl,
            'is_active' => $this->is_active,
        ];
    }
}
