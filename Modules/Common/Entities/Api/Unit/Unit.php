<?php

namespace Modules\Common\Entities\Api\Unit;

use Database\Factories\Unit\UnitFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Unit extends BaseModel
{
    use HasFactory;

    protected $table    = 'c_units';
    protected $fillable = [
        'name_ar',
        'name_en',
        'code',
        'is_active'
    ];

    protected  static function newFactory()
    {
        return UnitFactory::new();
    }
}
