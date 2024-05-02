<?php

namespace Modules\Common\Repositories\Eloquent\Unit;

use Modules\Common\Entities\Api\Unit\Unit;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Repositories\IRepositories\Unit\IUnitRepository;

class UnitRepository extends BaseRepository implements IUnitRepository
{
    public function model()
    {
        return Unit::class;
    }
}
