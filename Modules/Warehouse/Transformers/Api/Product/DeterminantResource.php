<?php

namespace Modules\Warehouse\Transformers\Api\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class DeterminantResource extends JsonResource
{
    public static $wrap = 'data';
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
            'name' => $request->header('index') == true ? $nameTrans[$key] ?? []: $nameTrans,
            'code' => $this->code ?? '',
            'smallint' => $this->smallint ?? '',
            'default_value' => $this->default_value ?? '',
            'max_qty' => $this->is_active ?? '',
            'is_unique' => $this->is_active ?? '',
            'is_active' => $this->is_active ?? '',
            'determinantsDetail' => DeterminantsDetailResource::collection($this->determinantsDetail),
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
