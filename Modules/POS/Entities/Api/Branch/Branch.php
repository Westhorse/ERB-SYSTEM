<?php

namespace Modules\POS\Entities\Api\Branch;

use App\Models\BaseModel;
use Modules\POS\Entities\Api\Cashier\Cashier;
use Modules\POS\Entities\Api\Period\Period;
use Modules\POS\QueryBuilders\Branch\BranchQueryBuilder;

class Branch extends BaseModel
{
    protected $table = "c_branches";
    public $translatable = ['name'];
    protected $fillable = [
        'name', 'region_id', 'country_id', 'currency_id', 'is_active'
    ];

    public function newEloquentBuilder($query): BranchQueryBuilder
    {
        return new BranchQueryBuilder($query);
    }

    public function cashiers()
    {
        return $this->hasMany(Cashier::class);
    }

    public function periods()
    {
        return $this->hasMany(Period::class);
    }
}
