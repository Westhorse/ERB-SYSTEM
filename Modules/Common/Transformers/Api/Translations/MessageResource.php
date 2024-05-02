<?php

namespace Modules\Common\Transformers\Api\Translations;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    protected $preserveKeys = true;

    public static $wrap = 'data';
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $valueTrans = $this->translations['value'];
        return [
            'id' => $this->id,
            'code' => $this->code,
            'key' => $this->key,
            'value'  => $valueTrans,
        ];
    }
}
