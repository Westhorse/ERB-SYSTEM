<?php

namespace Modules\FixedAsset\Entities\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\FixedAsset\Entities\Api\AssetGroup\FixedAssetGroup;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $table = "temp_accounts";

    public function fixedAssetGroups()
    {
        return $this->hasMany(FixedAssetGroup::class);
    }

}
