<?php

namespace Modules\Warehouse\Transformers\Api\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductTabulationResource extends JsonResource
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

        $notesTrans = $this->translations['notes'];
        $notesKey = fetchLangFromInputFields($notesTrans);
        return [
            'id' => $this->id,
            'name' => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'notes' => $request->header('index') == true ? $notesTrans[$notesKey] ?? [] : (object)$notesTrans,
            'printer' => $this->printer ?? '',
            'code' => $this->code ?? '',
            'is_active' => $this->is_active ?? '',
            'productTabulationDetail' => ProductTabulationDetailResource::collection($this->productTabulationDetail),
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
