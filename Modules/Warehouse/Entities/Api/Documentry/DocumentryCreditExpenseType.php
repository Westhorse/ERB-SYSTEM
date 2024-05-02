<?php

namespace  Modules\Warehouse\Entities\Api\Documentry;


use App\Models\BaseModel;
use Modules\Warehouse\Entities\Api\ShippingPolicy\ShippingPolicy;

class DocumentryCreditExpenseType extends BaseModel
{
    protected $table = "w_documentry_credit_expenses_type";
    public $translatable = ['name'];
    protected $guarded = [];


    public function shippingPolicy()
    {
        return $this->belongsToMany(
            ShippingPolicy::class,
            'w_documentry_credit_expenses_type_shipping_policy',
            'documentry_id',
            'shipping_id'
        )->withPivot('documentry_id', 'shipping_id');
    }
}
