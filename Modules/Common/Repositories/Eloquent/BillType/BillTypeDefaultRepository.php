<?php

namespace Modules\Common\Repositories\Eloquent\BillType;

use Modules\Common\Entities\Api\BillType\BillType;
use Modules\Common\Entities\Api\BillType\BillTypeDefault;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Repositories\IRepositories\BillType\IBillTypeDefaultRepository;

class BillTypeDefaultRepository extends BaseRepository implements IBillTypeDefaultRepository
{
    public function model()
    {
        return BillTypeDefault::class;
    }
}
