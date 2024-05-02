<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Product;

use App\Helpers\Constants;
use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\Product\Determinant;
use Modules\Warehouse\Repositories\IRepositories\Product\IProductDeterminantRepository;

class ProductDeterminantRepository extends BaseRepository implements IProductDeterminantRepository
{
    public function model()
    {
        return Determinant::class;
    }

    public function names()
    {
        $models =  $this->model->select(['id', 'name'])->get();
        return $models;
    }

    public function fetchDataWithRelationship($conditions = [], $columns = array('*')) {

        $order_by = request(Constants::ORDER_BY) ??null;
        $order_by_direction = request(Constants::ORDER_By_DIRECTION)??"asc";
        $filter_operator = request(Constants::FILTER_OPERATOR) ??"=";
        $filters = request(Constants::FILTERS) ?? [];
        $per_page = request(Constants::PER_PAGE) ?? 15;
        $paginate = request(Constants::PAGINATE)?? false;
        $query = $this->model->with('determinantsDetail');
        $all_conditions = array_merge($conditions, $filters);
        $query = $query->filter($all_conditions, $filter_operator);
        if (isset($order_by))
            $query = $query->orderBy($order_by, $order_by_direction);
        if($paginate)
            return $query->paginate($per_page, $columns);
        else
            return $query->get($columns);
    }
}
