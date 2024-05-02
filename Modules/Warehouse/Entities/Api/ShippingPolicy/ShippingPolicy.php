<?php

namespace  Modules\Warehouse\Entities\Api\ShippingPolicy;

use App\Models\BaseModel;

class ShippingPolicy extends BaseModel
{
    public $translatable = ['name', 'discription'];
    protected $table    = 'w_shipping_policy';
    protected $fillable = [
        'name',
        'code',
        'discription',
    ];
}
