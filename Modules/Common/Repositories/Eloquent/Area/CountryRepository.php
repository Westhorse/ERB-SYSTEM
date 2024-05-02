<?php

namespace Modules\Common\Repositories\Eloquent\Area;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\Area\Country;
use Modules\Common\Repositories\IRepositories\Area\ICountryRepository;

class CountryRepository extends BaseRepository implements ICountryRepository
{
    public function model()
    {
        return Country::class;
    }

}

