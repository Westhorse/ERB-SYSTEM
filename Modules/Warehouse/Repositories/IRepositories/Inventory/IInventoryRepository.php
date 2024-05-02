<?php


namespace Modules\Warehouse\Repositories\IRepositories\Inventory;

use App\Repositories\IRepositories\IBaseRepository;

interface IInventoryRepository extends IBaseRepository
{
    public function createRequest($request);

    public function updateRequest($request, $inventory);

    public function fillteredNames();

    public function gatherItems($ids);

    public function approve($request, $inventory);
}
