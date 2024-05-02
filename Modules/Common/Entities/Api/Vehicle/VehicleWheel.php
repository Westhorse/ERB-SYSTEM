<?php

namespace Modules\Common\Entities\Api\Vehicle;

use App\Models\BaseModel;

class VehicleWheel extends BaseModel
{

    protected $table = 'c_vehicle_wheels';

    protected $fillable = ["serial_no", "size", "description", "type", "wheel_date", "state", "prod_date", "notes", "guaranty_qty", "is_active", "vehicle_id", "wheel_id", "product_id", "warehouse_id"];


    public function wheel()
    {
        return $this->belongsTo(Wheel::class, 'wheel_id');
    }
}
