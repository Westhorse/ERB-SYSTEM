<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Product;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Warehouse\Repositories\IRepositories\Product\IPriceListRepository;
use App\Helpers\Constants;
use  Modules\Warehouse\Entities\Api\Product\PriceList;

class PriceListRepository extends BaseRepository implements IPriceListRepository
{
    public function model()
    {
        return PriceList::class;
    }
    public function fetchDataWithRelationship($conditions = [], $columns = array('*')) {

        $order_by = request(Constants::ORDER_BY) ??null;
        $order_by_direction = request(Constants::ORDER_By_DIRECTION)??"asc";
        $filter_operator = request(Constants::FILTER_OPERATOR) ??"=";
        $filters = request(Constants::FILTERS) ?? [];
        $per_page = request(Constants::PER_PAGE) ?? 15;
        $paginate = request(Constants::PAGINATE)?? false;
        $query = $this->model->with('priceListsDetail');
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
