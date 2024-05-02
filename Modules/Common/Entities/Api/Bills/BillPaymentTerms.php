<?php

namespace Modules\Common\Entities\Api\Bills;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillPaymentTerms extends Model
{
    use HasFactory;

    protected $table = 'c_bill_payment_terms';
    protected $fillable = [
        'bill_id', 'payment_amount',
        'payment_percent', 'payment_date',
        'remarks', 'notes',
    ];
    public $translatable = ['remarks', 'notes'];
    protected $casts = [
        'remarks' => 'json',
        'notes' => 'json',
    ];
}
