<?php

namespace Modules\Common\Repositories\Eloquent\Nationality;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\Nationality\Nationality;
use Modules\Common\Repositories\IRepositories\Nationality\INationalityRepository;

class NationalityRepository extends BaseRepository implements INationalityRepository
{
    public function model()
    {
        return Nationality::class;
    }
}
