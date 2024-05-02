<?php

namespace Modules\Common\Entities\Api\CarClassification;

use App\Models\BaseModel;

class CarClassification extends BaseModel
{


    protected $table = "c_vehicle_classifications";
    
    public $translatable = ['name'];

    protected $fillable = [
        'name', 'code', 'is_active'
    ];
}
