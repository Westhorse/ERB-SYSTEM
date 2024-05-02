<?php

namespace Modules\Common\Entities\Api\Bills;

use App\Models\BaseModel;

class BillEffect extends BaseModel
{
    protected $table = 'c_bill_effects';
    protected $fillable = [
        'bill_id', 'effect_type',
        'effect_amount_type', 'effect_amount',
        'account_id', 'remarks',
        'opposite_account_id', 'currency_id',
        'conversion_factor', 'reference',
        'reference_no',
    ];
    public $translatable = ['remarks'];

    protected static function newFactory()
    {
        return \Modules\Common\Database\factories\Api / Bills / BillEffectFactory::new();
    }
}
