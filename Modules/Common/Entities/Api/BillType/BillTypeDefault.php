<?php

namespace Modules\Common\Entities\Api\BillType;

use App\Models\BaseModel;

class BillTypeDefault extends BaseModel
{
    protected $table = 'c_bill_types_defaults';
    protected $guarded = [];
    public $translatable = [];
    protected $with = ['billTypeDefaultDetails'];

    protected static function newFactory()
    {
        return \Modules\Common\Database\factories\Api / BillType / BillTypeDefaultFactory::new();
    }
    public function reference()
    {
        return $this->belongsTo(BillType::class, 'reference_id');
    }

    public function billTypeDefaultDetails()
    {
        return $this->hasMany(BillTypeDefaultDetail::class, 'bill_type_default_id');
    }
}
