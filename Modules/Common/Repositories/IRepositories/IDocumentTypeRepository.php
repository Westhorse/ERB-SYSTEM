<?php


namespace Modules\Common\Repositories\IRepositories;

use App\Repositories\IRepositories\IBaseRepository;

interface IDocumentTypeRepository extends IBaseRepository
{
    /**
     * @param null
     * @param array null
     * @return mixed
     */
    public function getAllByType($dtype);
}
