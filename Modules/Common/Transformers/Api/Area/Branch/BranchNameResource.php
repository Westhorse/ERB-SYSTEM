<?php

namespace Modules\Common\Transformers\Api\Area\Branch;

use Modules\Common\Transformers\Api\Business\BusinessResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchNameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'business'      =>BusinessResource::collection($this->business) ?? '',

        ];
    }
}
