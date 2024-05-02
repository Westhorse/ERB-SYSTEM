<?php

namespace Modules\FixedAsset\Entities\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\FixedAsset\Entities\Api\AssetGroup\FixedAssetGroup;

class Group extends Model
{
    use HasFactory;

    protected $table = 'c_bill_types_groups';

    protected $fillable = [

        'name'
    ];


    public function fixedAssetGroups()
    {
        return $this->hasMany(FixedAssetGroup::class);
    }

}
