<?php


namespace Modules\Common\Repositories\IRepositories\Vehicle;

use App\Repositories\IRepositories\IBaseRepository;

interface IWheelRepository extends IBaseRepository
{
    public function getAllByType($vType);
}
