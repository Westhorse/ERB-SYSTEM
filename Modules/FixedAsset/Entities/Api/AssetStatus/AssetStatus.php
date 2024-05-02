<?php

namespace Modules\FixedAsset\Entities\Api\AssetStatus;

use Database\Factories\AssetStatus\AssetStatusFactory;
use App\Models\BaseModel;
use Modules\FixedAsset\Entities\Api\Branch;

class AssetStatus extends BaseModel
{
    protected $fillable     = ['name', 'code', 'is_active'];
    protected $table        = 'f_asset_status';
    public $translatable = ['name'];

    protected static function newFactory()
    {
        return AssetStatusFactory::new();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
