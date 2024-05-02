<?php

namespace Modules\Common\Entities\Api\Vehicle;

use App\Models\BaseModel;

class Account extends BaseModel
{
    protected $table = 'temp_accounts';
    protected $fillable = ['name_ar', 'name_en', 'code'];
}
