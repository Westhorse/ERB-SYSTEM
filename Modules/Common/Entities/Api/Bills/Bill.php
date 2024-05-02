<?php

namespace Modules\Common\Entities\Api\Bills;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\BaseModel;

class Bill extends BaseModel
{
    protected $table = 'c_bills';
    protected $fillable = [
        'bill_type_id', 'code',
        'vendor_bill_no', 'bill_version',
        'bill_date', 'payment_type',
        'days_count', 'currency_id',
        'conversion_factor', 'notes',
        'payment_account_id',
        'bill_account_id', 'ref_bill_type_id',
        'ref_bill_id', 'supply_date',
        'warehouse_id', 'cost_center_id',
        'representative_id', 'project_id',
        'customer_id', 'supplier_id',
        'remarks', 'driver_id',
        'car_id', 'trailer_id',
        'shipping_policy_id', 'shipping_type',
        'paid_account_id', 'rest_account_id',
        'paid_amount',
        'invoice_total',
        'invoice_total_tax',
        'branch_business_id',
    ];
    public $translatable = ['remarks', 'notes'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($bill) {
            $bill->items()->delete();
            $bill->effects()->delete();
            $bill->paymentTerms()->delete();
        });
    }
    /**
     * Get all of the items for the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(BillItem::class, 'bill_id', 'id');
    }

    public function BillType(): BelongsTo
    {
        return $this->belongsTo(BillType::class, 'bill_type_id');
    }

    /**
     * Get all of the effects for the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function effects(): HasMany
    {
        return $this->hasMany(BillEffect::class, 'bill_id', 'id');
    }

    /**
     * Get all of the paymentTerms for the Bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentTerms(): HasMany
    {
        return $this->hasMany(BillPaymentTerms::class, 'bill_id', 'id');
    }
}
