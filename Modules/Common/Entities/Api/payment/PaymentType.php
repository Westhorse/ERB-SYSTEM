<?php

namespace Modules\Common\Entities\Api\payment;

use App\Models\BaseModel;
use Modules\Common\Entities\Api\Vehicle\Account;

class PaymentType extends  BaseModel
{
    public $guarded = ['id'];
    protected $table ='c_payment_types';
    public $translatable = ['name'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
