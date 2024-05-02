<?php


namespace Modules\Common\Repositories\IRepositories\Translations;

use App\Repositories\IRepositories\IBaseRepository;

interface IMessageRepository extends IBaseRepository
{
    public function getAllObjects();

}
