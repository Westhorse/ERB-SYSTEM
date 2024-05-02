<?php

namespace Modules\Common\Entities\Api\Vehicle;

use App\Models\BaseModel;
use Database\Factories\Vehicle\VehicleTypeFactory;

class VehicleType extends BaseModel
{

    protected $table = 'c_vehicle_types';
    protected $fillable = ['name', 'code', 'vtype', 'is_active'];
    public $translatable = ['name'];


    protected static function newFactory()
    {
        return VehicleTypeFactory::new();
    }

    public function vehicleData()
    {
        return $this->hasMany(VehicleData::class);
    }
}
