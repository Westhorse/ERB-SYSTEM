<?php

namespace  Modules\Warehouse\Entities\Api\Supplier;

use App\Models\BaseModel;

class Supplier extends BaseModel
{
    protected $table = "w_suppliers";
    public $translatable = ['name','address'];
    protected $guarded = [];
}
