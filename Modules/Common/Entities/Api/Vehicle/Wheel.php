<?php

namespace Modules\Common\Entities\Api\Vehicle;

use App\Models\BaseModel;
use Database\Factories\Vehicle\WheelFactory;

class Wheel extends BaseModel
{

    public $translatable = ['name'];
    protected $table = 'c_wheels';
    protected $fillable = ['name', 'code', 'vtype', 'is_active'];

    protected static function newFactory()
    {
        return WheelFactory::new();
    }

    public function vehicleWheels()
    {
        return $this->hasMany(VehicleWheel::class, 'wheel_id');
    }
}
