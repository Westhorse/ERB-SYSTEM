<?php

namespace Modules\Common\Entities\Api\Area;

use App\Models\BaseModel;
use Database\Factories\Area\CountryFactory;

class Country extends BaseModel
{
    public $translatable = ['name'];
    protected $primarykey = 'id';
    protected $table = 'c_countries';
    protected $guarded = [];

   
}
