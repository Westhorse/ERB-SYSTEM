<?php


namespace Modules\Common\Repositories\IRepositories\Translations;

use App\Repositories\IRepositories\IBaseRepository;

interface IDefaultValueRepository extends IBaseRepository
{
    public function getCode();

    public function getByCode($code);
}
