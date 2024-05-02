<?php

namespace Modules\FixedAsset\Entities\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\FixedAsset\Entities\Api\AssetGroup\FixedAssetGroup;
use Modules\FixedAsset\Entities\Api\AssetStatus\AssetStatus;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';

    protected $guarded = [];


    public function fixedAssetGroups()
    {
        return $this->hasMany(FixedAssetGroup::class);
    }

    public function assetStatuses()
    {
        return $this->hasMany(AssetStatus::class);
    }
}
