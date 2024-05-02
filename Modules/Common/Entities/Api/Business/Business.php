<?php

namespace Modules\Common\Entities\Api\Business;

use App\Models\BaseModel;

class Business extends BaseModel
{
    protected $table = 'c_business';
    protected $fillable = ['name', 'code','is_active'];
    public $translatable = ['name'];

 
}
