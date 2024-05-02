<?php

namespace Modules\Common\Repositories\Eloquent\TimeZone;


use Modules\Common\Entities\Api\TimeZone\TimeZone;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Repositories\IRepositories\TimeZone\ITimeZoneRepository;

class TimeZoneRepository extends BaseRepository implements ITimeZoneRepository
{
    public function model()
    {
        return TimeZone::class;
    }



}
