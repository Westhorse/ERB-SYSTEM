<?php

namespace Modules\Common\Entities\Api\BillTypeGroup;

use App\Models\BaseModel;
use Database\Factories\BillTypeGroup\BillTypeGroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Common\Entities\Api\BillType\BillType;

class BillTypeGroup extends BaseModel
{
    use HasFactory;

    protected $table = 'c_bill_types_groups';
    public $translatable = ['name'];
    protected $fillable = [
        'name',
        'code',
        'is_active'
    ];

    protected static function newFactory()
    {
        return BillTypeGroupFactory::new();
    }

    public function billTypes()
    {
        return $this->hasMany(BillType::class);
    }
}
