<?php

namespace Modules\FixedAsset\Repositories\Eloquent\AssetStatus;

use App\Repositories\Eloquent\BaseRepository;
use Modules\FixedAsset\Entities\Api\AssetStatus\AssetStatus;
use Modules\FixedAsset\Repositories\IRepositories\IAssetStatus\IAssetStatusRepository;

class AssetStatusRepository extends BaseRepository implements IAssetStatusRepository
{
    public function model()
    {
        return AssetStatus::class;
    }
}
