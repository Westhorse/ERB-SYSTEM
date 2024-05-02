<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Unit;

use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\Unit\Unit;
use Modules\Warehouse\Repositories\IRepositories\Unit\IUnitRepository;

class UnitRepository extends BaseRepository implements IUnitRepository
{
    public function model()
    {
        return Unit::class;
    }


}
