<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Product;

use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\Product\Product;
use Modules\Warehouse\Repositories\IRepositories\Product\IProductRepository;

class ProductRepository extends BaseRepository implements IProductRepository
{
    public function model()
    {
        return Product::class;
    }

    public function getParent()
    {
        return $this->model->getParent();
    }
    
    public function names()
    {
        $models =  $this->model->select(['id', 'name','unit_id','sales_price'])->get();
        return $models;
    }
}
