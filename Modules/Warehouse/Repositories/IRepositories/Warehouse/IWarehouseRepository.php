<?php

namespace Modules\Warehouse\Repositories\IRepositories\Warehouse;

use App\Repositories\IRepositories\IBaseRepository;

interface IWarehouseRepository extends IBaseRepository
{

    public function getParents();
}
