<?php

namespace Modules\Common\Entities\Api\BillType;

use App\Models\BaseModel;

class BillTypeDefaultDetail extends BaseModel
{
    protected $table = 'c_bill_types_defaults_details';
    protected $guarded=[];
    public $translatable = ['label'];

    public function billTypeDefault()
    {
        return $this->belongsTo(BillTypeDefault::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\Common\Database\factories\Api/BillType/BillTypeDefaultDetailFactory::new();
    }
}
