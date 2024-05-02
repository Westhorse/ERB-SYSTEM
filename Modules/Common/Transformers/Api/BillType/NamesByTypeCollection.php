<?php

namespace Modules\Common\Transformers\Api\BillType;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NamesByTypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' =>  $request->typeId == 1 ? 'sale' : ($request->typeId == 2 ? 'purchases' : ($request->typeId == 3 ? 'return_sale' : ($request->typeId == 4 ? 'return_purchases' : ($request->typeId == 5 ? 'f_p_invioce' : '')))),
            'type' => 'folder',
            'childrens' => BillTypeNameResource::collection($this->collection),

        ];
    }
}
