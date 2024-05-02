<?php

namespace Modules\Warehouse\Transformers\Api\Tax;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxResource extends JsonResource
{
    // public static $wrap = 'data';

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
            // 'id' => $this->id,
            // 'code' => $this->code,
            'name' => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            // 'is_active' => $this->is_active,
            'taskDetails' => TaxDetailResource::collection($this->taskDetails),
            // 'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
