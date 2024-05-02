<?php


namespace Modules\Common\Entities\Api\Currency;

use App\Models\BaseModel;

class CurrencyExchange extends BaseModel
{
    protected $table = 'c_currencies_exchange';
    // protected $fillable = ['exchange_rate', 'exhange_date', 'from_currency_id','to_currency_id'];
    public $guarded = ['id'];
    public $translatable = [];



}
