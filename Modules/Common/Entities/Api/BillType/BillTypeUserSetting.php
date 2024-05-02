<?php

namespace Modules\Common\Entities\Api\BillType;

use App\Models\BaseModel;

class BillTypeUserSetting extends BaseModel
{
    protected $table = 'c_bill_types_users_settings';
    protected $guarded = [];
    public $translatable = [];

    protected $with = ['billTypeUserSettingsDetails'];

    public function reference_id()
    {
        return $this->belongsTo(BillType::class, 'reference_id');
    }

    public function billTypeUserSettingsDetails()
    {
        return $this->hasMany(BillTypeUserSettingDetail::class, 'bill_type_user_setting_id');
    }

    protected static function newFactory()
    {
        return \Modules\Common\Database\factories\Api / BillType / BillTypeUserSettingFactory::new();
    }
}
