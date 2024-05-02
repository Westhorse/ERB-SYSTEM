<?php

namespace Modules\Common\Repositories\Eloquent\BillType;

use Modules\Common\Entities\Api\BillType\BillTypeTax;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Repositories\IRepositories\BillType\IBillTypeTaxRepository;

class BillTypeTaxRepository extends BaseRepository implements IBillTypeTaxRepository
{
    public function model()
    {
        return BillTypeTax::class;
    }
}
