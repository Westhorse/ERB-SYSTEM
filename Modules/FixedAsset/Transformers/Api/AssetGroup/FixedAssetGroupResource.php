<?php

namespace Modules\FixedAsset\Transformers\Api\AssetGroup;

use Illuminate\Http\Resources\Json\JsonResource;

class FixedAssetGroupResource extends JsonResource
{

    public static $wrap = 'data' ;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $nameTrans = $this->translations['name'];
        $notesTrans = $this->translations['notes'];
        $key = fetchLangFromInputFields($nameTrans);
        $keyNotes = fetchLangFromInputFields($notesTrans);
        return [
            'id'                => $this->id,
            'code'              => $this->code,
            'name'              => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'notes'             => $request->header('index') == true ? $notesTrans[$keyNotes] ?? [] : (object)$notesTrans,
            'group_id'          => $this->group_id,
            'account_id'        => $this->account_id,
            'relate_with'       => $this->relate_with,
            'branch_id'         => $this->branch_id,
            'created_at'        => $this->created_at->format('d/m/Y')
        ];
    }
}
