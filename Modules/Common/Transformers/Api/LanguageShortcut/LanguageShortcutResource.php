<?php

namespace Modules\Common\Transformers\Api\LanguageShortcut;

use Illuminate\Http\Resources\Json\JsonResource;

class LanguageShortcutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [

                'id'           => $this->id,
                'shortcut'     => $this->shortcut,
                'created_at'   => $this->created_at->format('d/m/Y')
        ];
    }
}
