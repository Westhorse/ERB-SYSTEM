<?php

namespace  Modules\Warehouse\Entities\Api\Customer;
use App\Models\BaseModel;
class Customer extends BaseModel
{
    protected $table = "w_customers";
    public $translatable = ['name','address'];
    protected $guarded = [];
}
