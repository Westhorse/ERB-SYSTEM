<?php

namespace Modules\POS\Entities\Api\Cashier;

use App\Models\BaseModel;
use Modules\POS\Entities\Api\Branch\Branch;

class Cashier extends BaseModel
{
    protected $table = "pos_cashiers";
    public $translatable = ['name'];
    protected $fillable = [
        'code', 'name', 'is_active',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
