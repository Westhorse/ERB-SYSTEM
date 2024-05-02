<?php

namespace Modules\Common\Entities\Api\BillType;

use App\Models\BaseModel;

class BillTypeUserSettingDetail extends BaseModel
{
    protected $table = 'c_bill_types_users_settings_details';
    protected $guarded = [];
    public $translatable = ['label'];

    protected static function newFactory()
    {
        return \Modules\Common\Database\factories\Api / BillType / BillTypeUserSettingDetailFactory::new();
    }
}
