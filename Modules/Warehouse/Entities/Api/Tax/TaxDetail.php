<?php

namespace  Modules\Warehouse\Entities\Api\Tax;

use App\Models\BaseModel;
use Modules\Common\Entities\Api\Area\Country;
use  Modules\Warehouse\Entities\Api\Account;

class TaxDetail extends BaseModel
{
    protected $table = "c_taxes_detail";
    public $translatable = [];

    protected $fillable = [
        'amount_type', 'amount_value', 'impact', 'start_date', 'end_date', 'tax_id',
        'country_id', 'sales_tax_account_id', 'purchase_tax_account_id',
    ];

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function salesTaxAccount()
    {
        return $this->belongsTo(Account::class, 'sales_tax_account_id');
    }

    public function purchaseTaxAccount()
    {
        return $this->belongsTo(Account::class, 'purchase_tax_account_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
