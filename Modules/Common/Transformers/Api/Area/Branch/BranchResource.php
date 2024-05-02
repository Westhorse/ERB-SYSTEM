<?php

namespace Modules\Common\Transformers\Api\Area\Branch;

use Modules\Common\Transformers\Api\Business\BusinessResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $nameTrans = $this->translations['name'];
        $key = fetchLangFromInputFields($nameTrans);
        return [
            'id'            => $this->id,
            'code'          => $this->code,
            'name'          => $request->header('index') == true ? $nameTrans[$key] ?? [] : $nameTrans,
            'is_active'     => $this->is_active,
            'region_id'     => $this->region_id,
            'business'      => BusinessResource::collection($this->business) ?? '',
            'created_at'    => $this->created_at->format('d/m/Y')
        ];
    }
}
