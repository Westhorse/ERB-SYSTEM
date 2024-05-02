<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Product;

use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\Product\ProductTabulation;
use Modules\Warehouse\Repositories\IRepositories\Product\IProductTabulationRepository;

class ProductTabulationRepository extends BaseRepository implements IProductTabulationRepository
{
    public function model()
    {
        return ProductTabulation::class;
    }

}
