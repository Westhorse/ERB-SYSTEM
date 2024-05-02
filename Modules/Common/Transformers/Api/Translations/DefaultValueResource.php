<?php

namespace Modules\Common\Transformers\Api\Translations;

use Illuminate\Http\Resources\Json\JsonResource;

class DefaultValueResource extends JsonResource
{
    // protected $preserveKeys = true;

    public static $wrap = 'data';
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $valueTrans = $this->translations['label'];
        $key        = fetchLangFromInputFields($valueTrans);
        return [
            'id' => $this->id,
            'code' => $this->code,
            'value' => (int)$this->value,
            'label'  => $request->header('index') == true ? $valueTrans[$key] : $valueTrans,
        ];
    }
}
