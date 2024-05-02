<?php

namespace Modules\Common\Entities\Api\BillType;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\BaseModel;
use Modules\Common\Entities\Api\Area\Branch;
use Modules\Common\Entities\Api\Bills\Bill;
use Modules\Common\Entities\Api\BillTypeGroup\BillTypeGroup;
use Modules\Common\Entities\Api\Currency\Currency;
use Modules\Common\Entities\Api\Tax\Tax;

class BillType extends BaseModel
{
    protected $table = 'c_bill_types';
    protected $guarded = [];
    public $translatable = ['name'];

    protected static function newFactory()
    {
        return \Modules\Common\Database\factories\Api / BillType / BillTypeFactory::new();
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function transferBranch()
    {
        return $this->belongsTo(Branch::class, 'transfer_branch_id');
    }
    public function BillTypeGroup()
    {
        return $this->belongsTo(BillTypeGroup::class);
    }

    public function currencies()
    {
        return $this->belongsTo(Currency::class);
    }

    public function accumulatedBillType()
    {
        return $this->belongsTo(BillType::class, 'accumulated_bill_type_id');
    }

    public function changeBillType()
    {
        return $this->belongsTo(BillType::class, 'change_bill_type_id');
    }

    public function inBillType()
    {
        return $this->belongsTo(BillType::class, 'in_bill_type_id');
    }

    public function outBillType()
    {
        return $this->belongsTo(BillType::class, 'out_bill_type_id');
    }

    public function billTypeUserSettings()
    {
        return $this->hasMany(BillTypeUserSetting::class, 'reference_id');
    }

    public function billTypeDefaults()
    {
        return $this->hasOne(BillTypeDefault::class, 'reference_id');
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'c_bill_type_taxes', 'bill_type_id', 'tax_id')->withTimestamps();
    }
    public function taxesIds()
    {
        return $this->taxes()->pluck('tax_id')->toArray();
    }


    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }
}
