<?php

namespace Modules\Common\Repositories\Eloquent\Area;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\Area\Branch;
use Modules\Common\Repositories\IRepositories\Area\IBranchRepository;

class BranchRepository extends BaseRepository implements IBranchRepository
{
    public function model()
    {
        return Branch::class;
    }
}
