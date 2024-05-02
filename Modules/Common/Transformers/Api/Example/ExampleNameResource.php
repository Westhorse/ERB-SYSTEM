<?php

namespace Modules\Common\Transformers\Api\Example;
use Illuminate\Http\Resources\Json\JsonResource;
use function app;

class ExampleNameResource extends JsonResource
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
            'id' => $this->id,
            'name' => 'name_' . app()->getLocale(),
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
        ];
    }
}
