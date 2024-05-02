<?php


namespace Modules\Common\Repositories\IRepositories\BillTypeGroup;

use App\Repositories\IRepositories\IBaseRepository;

interface IBillTypeGroupRepository extends IBaseRepository
{
    public function names();
}
