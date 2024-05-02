<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Guarantee;

use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\Guarantee\Guarantee;
use Modules\Warehouse\Repositories\IRepositories\Guarantee\IGuaranteeRepository;

class GuaranteeRepository extends BaseRepository implements IGuaranteeRepository
{
    public function model()
    {
        return Guarantee::class;
    }

}
