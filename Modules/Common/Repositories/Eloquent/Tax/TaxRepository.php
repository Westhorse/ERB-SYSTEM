<?php

namespace Modules\Common\Repositories\Eloquent\Tax;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\Tax\Tax;
use Modules\Common\Repositories\IRepositories\Tax\ITaxRepository;

class TaxRepository extends BaseRepository implements ITaxRepository
{
    public function model()
    {
        return Tax::class;
    }

    public function names()
    {
        $models =  $this->model->select(['id', 'name'])->get();
        return $models;
    }
}
