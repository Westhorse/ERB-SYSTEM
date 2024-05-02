<?php

namespace Modules\Common\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\CarStatus\CarStatus;
use Modules\Common\Repositories\IRepositories\ICarStatusRepository;

class CarStatusRepository extends BaseRepository implements ICarStatusRepository
{
    public function model()
    {
        return CarStatus::class;
    }
}
