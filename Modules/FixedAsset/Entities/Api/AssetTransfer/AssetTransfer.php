<?php

namespace Modules\FixedAsset\Entities\Api\AssetTransfer;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Common\Entities\Api\Area\Tempuser;

class AssetTransfer extends BaseModel
{
    protected $table = "f_asset_transfer";
    public $translatable = ['remarks'];
    public $guarded = ['id'];


    // temp_users

    public function tempUsers(): BelongsTo
    {
        return $this->belongsTo(Tempuser::class, 'user_id');
    }
}
