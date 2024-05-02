<?php

namespace Modules\Common\Transformers\Api\Example;

use Illuminate\Http\Resources\Json\JsonResource;

class ExampleResource extends JsonResource
{

    public static $wrap = 'data';
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $nameTrans = $this->translations['name'];
        $notesTrans = $this->translations['notes'];
        $key        = fetchLangFromInputFields($nameTrans);
        $keyNotes   = fetchLangFromInputFields($notesTrans);

        return [
            'name'  => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'notes' => $request->header('index') == true ? $notesTrans[$keyNotes] ?? [] : $notesTrans,
        ];

    }
}
