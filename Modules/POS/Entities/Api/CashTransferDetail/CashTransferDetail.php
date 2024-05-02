<?php

namespace Modules\POS\Entities\Api\CashTransferDetail;

use App\Models\BaseModel;
use Modules\POS\Entities\Api\CashTransfer\CashTransfer;

class CashTransferDetail extends BaseModel
{
    protected $table = "pos_cash_transfer_detail";
    protected $translatable = [];
    protected $fillable = [
        'transfer_id',
        'part_id',
        'part_count',
    ];

    public function cashTransfer()
    {
        return $this->belongsTo(CashTransfer::class, 'transfer_id', 'id');
    }
}
