<?php

namespace Modules\Common\Repositories\Eloquent\Localization;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\Localization\District;
use Modules\Common\Repositories\IRepositories\Localization\IDistrictRepository;

class DistrictRepository extends BaseRepository implements IDistrictRepository
{
    public function model()
    {
        return District::class;
    }
}
