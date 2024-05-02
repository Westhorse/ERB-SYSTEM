<?php

namespace Modules\Warehouse\Transformers\Api\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Warehouse\Transformers\Api\Warehouse\ChildrenResourceTree;

class ProductCategoryTreeResource extends JsonResource
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
        $nameKey = fetchLangFromInputFields($nameTrans);

        $notesTrans = $this->translations['notes'];
        $notesKey = fetchLangFromInputFields($notesTrans);
        $tr = 1;
        return [
            'id' => $this->id,
            'name' => $request->header('index') == true ? $nameTrans[$nameKey] : $nameTrans,
            'type'          => 'product-categories',
            'is_active'     => $this->is_active,
            'is_product_category'=> $this->is_active == true ? $tr : 0,
            'parent_id' => $this->parent_id ?? '',
            'children'  => [
                ChildrenResourceTree::collection($this->children),
                ProductNamesTreeResource::collection($this->products),
            ],
        ];
    }
}
