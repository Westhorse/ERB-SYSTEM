<?php

namespace Modules\Common\Transformers\Api\Translations;

use Illuminate\Http\Resources\Json\JsonResource;

class DefaultValueCodeResource extends JsonResource
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
        return [
            'code' => $this->code,
        ];
    }
}
