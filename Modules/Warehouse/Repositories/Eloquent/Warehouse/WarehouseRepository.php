<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Warehouse;

use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\Warehouse\Warehouse;
use Modules\Warehouse\Repositories\IRepositories\Warehouse\IWarehouseRepository;

class WarehouseRepository extends BaseRepository implements IWarehouseRepository
{
    public function model()
    {
        return Warehouse::class;
    }

    public function getParents()
    {
        return Warehouse::parents();
    }
}
