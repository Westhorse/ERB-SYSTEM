<?php

namespace Modules\Common\Entities\Api\TimeZone;

use App\Models\BaseModel;

class TimeZone extends BaseModel
{
    protected $table = 'c_time_zone';
    protected $guarded=[];
    public $translatable = [];


}
