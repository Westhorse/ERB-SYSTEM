<?php

namespace Modules\Common\Repositories\Eloquent\BillTypeGroup;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\BillTypeGroup\BillTypeGroup;
use Modules\Common\Repositories\IRepositories\BillTypeGroup\IBillTypeGroupRepository;

class BillTypeGroupGroupRepository extends BaseRepository implements IBillTypeGroupRepository
{
    public function model()
    {
        return BillTypeGroup::class;
    }

}
