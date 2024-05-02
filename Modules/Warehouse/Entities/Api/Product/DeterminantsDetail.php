<?php

namespace  Modules\Warehouse\Entities\Api\Product;

use App\Models\BaseModel;

class DeterminantsDetail extends BaseModel
{
    public $guarded = ['id'];
    public $translatable = ['name'];
    protected $table ='w_determinants_detail';
}
