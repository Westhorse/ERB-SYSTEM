<?php

namespace Modules\Common\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\CarClassification\CarClassification;
use Modules\Common\Repositories\IRepositories\ICarClassificationRepository;

class CarClassificationRepository extends BaseRepository implements ICarClassificationRepository
{
    public function model()
    {
        return CarClassification::class;
    }
}