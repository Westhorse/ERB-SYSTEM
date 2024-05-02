<?php

namespace Modules\Common\Entities\Api\BillType;

use App\Models\BaseModel;

class BillTypeTax extends BaseModel
{
    protected $table = 'c_bill_type_taxes';
    protected $guarded = [];
    public $translatable = [];

    protected static function newFactory()
    {
        return \Modules\Common\Database\factories\Api / BillType / BillTypeTaxFactory::new();
    }
}
