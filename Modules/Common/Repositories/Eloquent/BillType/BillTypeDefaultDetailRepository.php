<?php

namespace Modules\Common\Repositories\Eloquent\BillType;

use Modules\Common\Entities\Api\BillType\BillTypeDefaultDetail;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Repositories\IRepositories\BillType\IBillTypeDefaultDetailRepository;

class BillTypeDefaultDetailRepository extends BaseRepository implements IBillTypeDefaultDetailRepository
{
    public function model()
    {
        return BillTypeDefaultDetail::class;
    }
}
