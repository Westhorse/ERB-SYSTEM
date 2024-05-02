<?php

namespace Modules\Common\Transformers\Api\Vehicle;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleWheelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
////
//        $nameTrans = $this->translations['description'];
//        $key = fetchLangFromInputFields($nameTrans);

        return [

            'serial_no' => $this->serial_no,
            'size' => $this->size,
//            'description' => $this->description,
            'type' => $this->type,
            'wheel_date' => $this->wheel_date,
            'state' => $this->state,
            'prod_date' => $this->prod_date,
            'notes' => $this->notes,
            'guaranty_qty' => $this->guaranty_qty,
            'vehicle_id' => $this->vehicle_id,
            'wheel_id' => $this->wheel_id,
//            'description' => $request->header('index') == true ? $nameTrans[$key] ?? []  : $nameTrans,

//            'wheel_name' => $request->header('index') == true ? $nameTrans[$key] : $nameTrans ,
//            'description' => $request->header('index') == true ? $nameTrans[$key] : $nameTrans ,
            'product_id' => $this->product_id,
            'warehouse_id' => $this->warehouse_id,
//            'product_name'=>$request->header('index') == true ? $nameTrans[$key] : $nameTrans ,
//            'warehouse'=>$request->header('index') == true ? $nameTrans[$key] : $nameTrans ,



            'is_active'                  => $this->is_active,



        ];
    }
}
