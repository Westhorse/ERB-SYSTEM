<?php

namespace  Modules\Warehouse\Entities\Api\Guarantee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Database\Factories\Guarantee\GuaranteeFactory;

class Guarantee extends BaseModel
{
    public $translatable = ['name'];
    protected $table = "w_guarantee";
    protected $fillable = [
        'name',
        'code',
        'is_active'
    ];

    protected static function newFactory()
    {
        return GuaranteeFactory::new();
    }

}
