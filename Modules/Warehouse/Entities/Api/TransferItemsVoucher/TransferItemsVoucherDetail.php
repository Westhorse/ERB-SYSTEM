<?php

namespace  Modules\Warehouse\Entities\Api\TransferItemsVoucher;

use App\Models\BaseModel;

class TransferItemsVoucherDetail extends BaseModel
{

    protected $table = "w_transfer_items_voucher_details";
    public $translatable = [];
    protected $fillable = [
        'transfer_id',
        'product_id',
        'unit_id',
        'product_qty',
        'converted_product_qty',
        'cost_price',
    ];

    
}
