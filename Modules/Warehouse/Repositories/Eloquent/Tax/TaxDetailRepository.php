<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Tax;

use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\Tax\TaxDetail;
use Modules\Warehouse\Repositories\IRepositories\Tax\ITaxDetailRepository;

class TaxDetailRepository extends BaseRepository implements ITaxDetailRepository
{
    public function model()
    {
        return TaxDetail::class;
    }
}
