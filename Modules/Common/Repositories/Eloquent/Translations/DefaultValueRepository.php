<?php

namespace Modules\Common\Repositories\Eloquent\Translations;

use Modules\Common\Entities\Api\Translations\DefaultValue;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Repositories\IRepositories\Translations\IDefaultValueRepository;

class DefaultValueRepository extends BaseRepository implements IDefaultValueRepository
{
    public function model()
    {
        return DefaultValue::class;
    }

    public function getCode()
    {
        return  $this->model->select('code')->distinct()->get();
    }
    public function getByCode($code)
    {
        return  $this->model->where('code', $code)->orderBy('value', 'ASC')->get();
    }
}
