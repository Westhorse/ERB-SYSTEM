<?php

namespace Modules\Common\Entities\Api\Vehicle;

use App\Models\BaseModel;
use Modules\Common\Entities\Api\BillType\BillTypeDefault;
use Modules\Common\Entities\Api\BillType\BillTypeUserSetting;

class CostCenter extends BaseModel
{

    protected $table = 'temp_cost_centers';
    protected $fillable = ['name_ar', 'name_en', 'code'];

    public function billTypeDefault()
    {
        return $this->hasMany(BillTypeDefault::class);
    }

    public function billTypeUserSettings()
    {
        return $this->hasMany(BillTypeUserSetting::class);
    }
}
