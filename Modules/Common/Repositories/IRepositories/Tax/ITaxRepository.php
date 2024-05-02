<?php


namespace Modules\Common\Repositories\IRepositories\Tax;

use App\Repositories\IRepositories\IBaseRepository;

interface ITaxRepository extends IBaseRepository
{
    public function names();
}
