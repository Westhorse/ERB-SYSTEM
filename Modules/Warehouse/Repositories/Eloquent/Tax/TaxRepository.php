<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Tax;

use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\Tax\Tax;
use Modules\Warehouse\Repositories\IRepositories\Tax\ITaxRepository;

class TaxRepository extends BaseRepository implements ITaxRepository
{
    public function model()
    {
        return Tax::class;
    }

}
