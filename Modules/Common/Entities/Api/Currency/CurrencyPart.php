<?php

namespace Modules\Common\Entities\Api\Currency;

use App\Models\BaseModel;

class CurrencyPart extends BaseModel
{

    protected $table = 'c_currencies_parts';
    protected $fillable = ['name', 'rate','currency_id','is_active'];
    public $translatable = ['name'];

}
