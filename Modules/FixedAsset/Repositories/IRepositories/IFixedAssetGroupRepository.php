<?php


namespace Modules\FixedAsset\Repositories\IRepositories;

use App\Repositories\IRepositories\IBaseRepository;

interface IFixedAssetGroupRepository extends IBaseRepository
{
    public function fetchDataWithRelationship();
}
