<?php

namespace Modules\Common\Entities\Api\Localization;

use App\Models\BaseModel;

class District extends BaseModel
{

    protected $table = "c_districts";
    public $translatable = ['name'];

    protected $fillable = [
        'name', 'code', 'is_active'
    ];
}
