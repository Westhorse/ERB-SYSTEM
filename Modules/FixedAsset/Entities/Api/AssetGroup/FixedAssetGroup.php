<?php

namespace Modules\FixedAsset\Entities\Api\AssetGroup;

use Database\Factories\AssetGroup\FixedAssetGroupFactory;
use Modules\FixedAsset\Entities\Api\Account;
use App\Models\BaseModel;
use Modules\FixedAsset\Entities\Api\Group;

class FixedAssetGroup extends BaseModel
{

    protected $fillable = [

        'code',
        'name',
        'group_id',
        'account_id',
        'relate_with',
        'branch_id',
        'notes',
    ];

    public $translatable = ['name', 'notes'];
    protected $table = 'f_asset_groups';

    protected static function newFactory()
    {
        return  FixedAssetGroupFactory::new();
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
