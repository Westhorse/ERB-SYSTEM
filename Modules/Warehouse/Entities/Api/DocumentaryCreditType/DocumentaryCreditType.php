<?php

namespace  Modules\Warehouse\Entities\Api\DocumentaryCreditType;
use App\Models\BaseModel;


class DocumentaryCreditType extends BaseModel
{
    protected $table = "w_documentary_credit_types";
    public $translatable = ['name'];
    protected $fillable = [
        'code',
        'name',
        'shipping_policy_id',
        'shipping_type',
        'credit_ref_bill_type_id',
        'shipping_bill_type_id',
        'receive_bill_type_id'
    ];
}
