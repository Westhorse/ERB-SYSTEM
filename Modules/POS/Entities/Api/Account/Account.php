<?php

namespace Modules\POS\Entities\Api\Account;

use App\Models\BaseModel;
use Modules\POS\Entities\Api\Period\Period;

class Account extends BaseModel
{
    protected $table = "temp_accounts";
    public $translatable = ['name'];
    protected $fillable = [
        'code', 'name',
    ];

    public function period()
    {
        return $this->hasMany(Period::class);
    }
}
