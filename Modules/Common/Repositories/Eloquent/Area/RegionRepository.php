<?php

namespace Modules\Common\Repositories\Eloquent\Area;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\Area\Region;
use Modules\Common\Repositories\IRepositories\Area\IRegionRepository;

class RegionRepository extends BaseRepository implements IRegionRepository
{
    public function model()
    {
        return Region::class;
    }
}
