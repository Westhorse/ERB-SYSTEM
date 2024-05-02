<?php


namespace Modules\Warehouse\Repositories\IRepositories\Product;

use App\Repositories\IRepositories\IBaseRepository;

interface IProductRepository extends IBaseRepository
{
    public function names();
}
