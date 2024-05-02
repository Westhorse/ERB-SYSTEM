<?php

namespace Modules\Common\Entities\Api\BillInstallments;

use App\Models\BaseModel;

class BillInstallmentDetail extends BaseModel
{
    protected $table = 'c_bill_installment_details';
    protected $fillable = [
        'bill_installment_id',
        'installment_date',
        'installment_value',
        'installment_status',
        'remarks'
    ];
    public $translatable = ['remarks'];
}
