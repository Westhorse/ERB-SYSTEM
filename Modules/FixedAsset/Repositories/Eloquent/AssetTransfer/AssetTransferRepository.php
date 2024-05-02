<?php

namespace Modules\FixedAsset\Repositories\Eloquent\AssetTransfer;

use App\Repositories\Eloquent\BaseRepository;
use Modules\FixedAsset\Entities\Api\AssetTransfer\AssetTransfer;
use Modules\FixedAsset\Repositories\IRepositories\IAssetTransfer\IAssetTransferRepository;

class AssetTransferRepository extends BaseRepository implements IAssetTransferRepository
{
    public function model()
    {
        return AssetTransfer::class;
    }
}
