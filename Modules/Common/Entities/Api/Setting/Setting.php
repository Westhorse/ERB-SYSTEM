<?php

namespace Modules\Common\Entities\Api\Setting;

use App\Models\BaseModel;

class Setting extends BaseModel
{
    public $guarded = [];
    protected $table ='c_settings';
    public $translatable = ['setting_value'];

}
