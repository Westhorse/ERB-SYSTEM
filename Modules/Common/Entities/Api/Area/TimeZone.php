<?php

namespace Modules\Common\Entities\Api\Area;

use App\Models\BaseModel;

class TimeZone extends BaseModel
{
    public $translatable = [];
    protected $table = 'c_time_zone';
}
