<?php

namespace Modules\Warehouse\Transformers\Api\Offer;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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

        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $request->header('index') == true ? $nameTrans[$nameKey] ?? []: $nameTrans,
            'notes' => $request->header('index') == true ? $notesTrans[$notesKey] ?? []: (object)$notesTrans,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'warehouse_id' => $this->warehouse_id,
            'is_active' => $this->is_active,
            'offerDetails'=>OfferDetailResource::collection($this->offerDetails) ?? '',
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
