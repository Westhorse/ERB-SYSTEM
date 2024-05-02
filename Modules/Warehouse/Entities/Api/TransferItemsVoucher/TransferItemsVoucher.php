<?php

namespace  Modules\Warehouse\Entities\Api\TransferItemsVoucher;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class TransferItemsVoucher extends BaseModel
{

    protected $table = "w_transfer_items_vouchers";
    public $translatable = ['remarks'];
    protected $fillable = [
        'voucher_date',
        'ref_bill_type_id',
        'ref_bill_id',
        'src_warehouse_id',
        'dest_warehouse_id',
        'currency_id',
        'conversion_rate',
        'src_branch_id',
        'dest_branch_id',
        'in_bill_type_id',
        'out_bill_type_id',
        'remarks',
        'deliverer_id',
        'receiver_id',
        'input_cost_center_id',
        'output_cost_center_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($voucher) {
            foreach ($voucher->billsIds() as $bill) {
                DB::table('c_bills_items')->where('bill_id', $bill)->update(['deleted_at' => Carbon::now()]);
                DB::table('c_bills')->where('id', $bill)->update(['deleted_at' => Carbon::now()]);
            }
            $voucher->details()->delete();
        });
    }

    /**
     * Get all of the details for the BillInstallment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(TransferItemsVoucherDetail::class, 'transfer_id', 'id');
    }

    public function billsIds()
    {
        return DB::table('c_bills')->where('transfer_id', $this->id)->pluck('id');
    }
}
