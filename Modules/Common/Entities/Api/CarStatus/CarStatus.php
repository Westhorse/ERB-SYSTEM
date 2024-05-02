<?php

namespace Modules\Common\Entities\Api\CarStatus;


use App\Models\BaseModel;

class CarStatus extends BaseModel
{
    protected $table = "c_car_status";
    public $translatable = ['name'];

    protected $guarded = [];


}
