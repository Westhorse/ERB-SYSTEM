<?php


namespace Modules\Common\Repositories\IRepositories\Translations;

use App\Repositories\IRepositories\IBaseRepository;

interface ICaptionRepository extends IBaseRepository
{

    /**
     * 
     * @return mixed
     */
    public function fetchKeys();

    /**
     * 
     * @return mixed
     */
    public function fetchByCode($code);
    
    public function getAllObjects();
}
