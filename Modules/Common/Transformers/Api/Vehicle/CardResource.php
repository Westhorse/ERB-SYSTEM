<?php

namespace Modules\Common\Transformers\Api\Vehicle;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
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

            "id"      => $this->id,
            "doc_serial"     => $this->doc_serial,
            "start_date"   => $this->start_date,
            "end_date"     => $this->end_date,
            "notes"  => $this->notes,
            "value"  => $this->value,
            "vehicle_data_id"  => $this->vehicle_data_id,
            "document_type_id"  => $this->document_type_id,
            "document_issuer_id"   => $this->document_issuer_id,
            "issue_place"=>$this->issue_place


        ];
    }
}
