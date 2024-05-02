<?php

namespace Modules\POS\Entities\Api\Period;

use App\Models\BaseModel;
use Modules\POS\Entities\Api\Account\Account;
use Modules\POS\Entities\Api\Branch\Branch;

class Period extends BaseModel
{
    protected $table = "pos_periods";
    public $translatable = ['name'];
    protected $fillable = [
        'code', 'branch_id', 'account_id', 'name', 'from_time', 'to_time',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'c_branches', 'branch_id');
    }
}
