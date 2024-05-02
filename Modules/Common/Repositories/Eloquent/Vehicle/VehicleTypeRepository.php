<?php

namespace Modules\Common\Repositories\Eloquent\Vehicle;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\Vehicle\VehicleType;
use Modules\Common\Repositories\IRepositories\Vehicle\IVehicleTypeRepository;

class VehicleTypeRepository extends BaseRepository implements IVehicleTypeRepository
{
    public function model()
    {
        return VehicleType::class;
    }

    public function getAllByType($vType)
    {
        return VehicleType::where('vtype', $vType)->get();
    }
}
