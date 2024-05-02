<?php

namespace Modules\Common\Entities\Api\Area;

use App\Models\BaseModel;

class Tempuser extends BaseModel
{
    public $translatable = [];
    protected $table = 'temp_users';
}
