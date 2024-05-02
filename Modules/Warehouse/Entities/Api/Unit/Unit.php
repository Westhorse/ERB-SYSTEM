<?php

namespace  Modules\Warehouse\Entities\Api\Unit;

use App\Models\BaseModel;
// use Database\Factories\Unit\UnitFactory;

class Unit extends BaseModel
{
    public $translatable = ['name'];
    protected $table    = 'w_units';
    protected $fillable = [
        'name',
        'code',
        'is_active'
    ];

    // protected static function newFactory()
    // {
    //     return UnitFactory::new();
    // }
}
