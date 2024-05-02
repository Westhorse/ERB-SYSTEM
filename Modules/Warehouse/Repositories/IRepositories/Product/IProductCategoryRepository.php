<?php


namespace Modules\Warehouse\Repositories\IRepositories\Product;

use App\Repositories\IRepositories\IBaseRepository;

interface IProductCategoryRepository extends IBaseRepository
{
    public function names();
    public function namesWithTypeIsFixedAsset();
    public function namesWithType($type);
    public function getParents();
    public function getdata();
}
