<?php

namespace Modules\POS\Repositories\IRepositories\IPointSection;

use App\Repositories\IRepositories\IBaseRepository;

interface IPointSectionRepository extends IBaseRepository
{
    public function getPointSectionsAndSettingValue();

}
