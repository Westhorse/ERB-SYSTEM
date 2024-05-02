<?php

namespace Modules\Common\Repositories\Eloquent\Business;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\Business\Business;
use Modules\Common\Repositories\IRepositories\Business\IBusinessRepository;

class BusinessRepository extends BaseRepository implements IBusinessRepository
{
    public function model()
    {
        return Business::class;
    }

    

}