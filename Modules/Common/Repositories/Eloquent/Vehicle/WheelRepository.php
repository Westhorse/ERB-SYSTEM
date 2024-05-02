<?php

namespace Modules\Common\Repositories\Eloquent\Vehicle;

use  App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\Vehicle\Wheel;
use Modules\Common\Repositories\IRepositories\Vehicle\IWheelRepository;

class WheelRepository extends BaseRepository implements IWheelRepository
{
    public function model()
    {
        return Wheel::class;
    }

    public function getAllByType($vType)
    {
        return Wheel::where('vtype', $vType)->get();
    }
}
