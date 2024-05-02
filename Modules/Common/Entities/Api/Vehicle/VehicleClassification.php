<?php

namespace Modules\Common\Entities\Api\Vehicle;

use App\Models\BaseModel;

class VehicleClassification extends BaseModel
{

    protected $table = 'c_vehicle_classifications';
    protected $fillable = ['name_ar', 'name_en', 'code', 'is_active'];
}
