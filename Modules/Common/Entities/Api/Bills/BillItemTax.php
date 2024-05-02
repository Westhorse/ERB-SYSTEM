<?php

namespace Modules\Common\Entities\Api\Bills;

use App\Models\BaseModel;

class BillItemTax extends BaseModel
{
    protected $table = 'c_bill_items_taxes';
    protected $fillable = [
        'bill_item_id', 'tax_id',
        'tax_percent', 'tax_value',
    ];
    public $translatable = [];
    protected static function newFactory()
    {
        return \Modules\Common\Database\factories\Api / Bills / BillItemTaxFactory::new();
    }
}
