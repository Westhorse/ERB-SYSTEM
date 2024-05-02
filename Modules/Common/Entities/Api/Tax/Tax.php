<?php

namespace Modules\Common\Entities\Api\Tax;

use App\Models\BaseModel;

class Tax extends BaseModel
{
    protected $table = 'c_taxes';
    // protected $primarykey='id';
    protected $guarded=[];
    public $translatable = ['name'];

//
    public function countries()
    {
        return $this->hasMany(TaxDetail::class,'tax_id');
//        return $this->belongsToMany(Country::class, 'c_taxes_detail','tax_id','country_id')
//            ->withPivot('amount_type','amount_value','start_date','end_date','impact','country_id','tax_id');
    }


//    public function countries()
//    {
//        return $this->hasMany(TaxDetail::class, 'tax_id');
//    }
}
