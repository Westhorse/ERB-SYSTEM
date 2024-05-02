<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Supplier;

use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\Supplier\Supplier;
use Modules\Warehouse\Repositories\IRepositories\Supplier\ISupplierRepository;

class SupplierRepository extends BaseRepository implements ISupplierRepository
{
    public function model()
    {
        return Supplier::class;
    }

}
