<?php

namespace Modules\POS\Entities\Api\CashTransfer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Modules\POS\Entities\Api\CashTransferDetail\CashTransferDetail;

class CashTransfer extends BaseModel
{
    use HasFactory;
    protected $table = "pos_cash_transfer";
    protected $translatable = [];

    protected $fillable = [
        'src_user_id',
        'src_pos_id',
        'src_period_id',
        'trans_date',
        'dest_user_id',
        'dest_pos_id',
        'dest_period_id',
        'amount_value',
        'currency_id'
    ];

    public function cashTransferDetails()
    {
        return $this->hasMany(CashTransferDetail::class, 'transfer_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($cashTransfer) {
            $cashTransfer->cashTransferDetails()->delete();
        });
    }


    public function cashTransferDetailsWithRate()
    {
        $cashTransferWithRate =  DB::table('pos_cash_transfer')
            ->join('pos_cash_transfer_detail', 'pos_cash_transfer.id', '=', 'pos_cash_transfer_detail.transfer_id')
            ->join('c_currencies_parts', 'c_currencies_parts.id', '=', 'pos_cash_transfer_detail.part_id')
            ->select(
                'pos_cash_transfer_detail.id',
                'pos_cash_transfer_detail.part_id',
                'pos_cash_transfer_detail.part_count',
                'c_currencies_parts.rate'
            )
            ->get();
        return $cashTransferWithRate;
    }
}
