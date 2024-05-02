<?php

namespace Modules\Common\Entities\Api\Currency;

use App\Models\BaseModel;
use Modules\Common\Entities\Api\BillType\BillType;

class Currency extends BaseModel
{

    protected $table = 'c_currencies';
    public $guarded = ['id'];
    public $translatable = ['name','part_name'];

    public function currencyPart()
    {
        return $this->hasMany(CurrencyPart::class,'currency_id');
    }

    public function currencyExchange()
    {
        return $this->hasMany(CurrencyExchange::class,'from_currency_id');
    }
    public function billTypes()
    {
        return $this->hasMany(BillType::class);
    }
}

