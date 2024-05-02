<?php

namespace Modules\Common\Entities\Api\BillInstallments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillInstallment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'c_bill_installments';
    protected $fillable = [
        'bill_id',
        'installment_way',
        'period_start',
        'calc_by_hijri',
        'first_payment',
        'first_payment_date',
        'start_date',
        'installment_value',
        'installment_count',
    ];


    /**
     * Get all of the details for the BillInstallment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(BillInstallmentDetail::class, 'bill_installment_id', 'id');
    }
}
