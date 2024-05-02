<?php

namespace Modules\FixedAsset\Repositories\Eloquent;

use App\Helpers\Constants;
use App\Repositories\Eloquent\BaseRepository;
use Modules\FixedAsset\Entities\Api\AssetGroup\FixedAssetGroup;
use Modules\FixedAsset\Repositories\IRepositories\IFixedAssetGroupRepository;

class FixedAssetGroupRepository extends BaseRepository implements IFixedAssetGroupRepository
{


    public function model()
    {
        return FixedAssetGroup::class;
    }


    public function fetchDataWithRelationship($conditions = [], $columns = array('*')) {

        $order_by = request(Constants::ORDER_BY) ??null;
        $order_by_direction = request(Constants::ORDER_By_DIRECTION)??"asc";
        $filter_operator = request(Constants::FILTER_OPERATOR) ??"=";
        $filters = request(Constants::FILTERS) ?? [];
        $per_page = request(Constants::PER_PAGE) ?? 15;
        $paginate = request(Constants::PAGINATE)?? false;
        $query = $this->model->with('account', 'group');
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
