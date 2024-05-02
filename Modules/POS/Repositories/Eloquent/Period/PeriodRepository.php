<?php

namespace Modules\POS\Repositories\Eloquent\Period;

use App\Repositories\Eloquent\BaseRepository;
use Modules\POS\Entities\Api\Period\Period;
use Modules\POS\Repositories\IRepositories\IPeriod\IPeriodRepository;

class PeriodRepository extends BaseRepository implements IPeriodRepository
{
    public function model()
    {
        return Period::class;
    }
}
