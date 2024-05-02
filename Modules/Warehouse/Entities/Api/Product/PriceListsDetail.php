<?php

namespace  Modules\Warehouse\Entities\Api\Product;

use App\Models\BaseModel;
use  Modules\Warehouse\Entities\Api\Unit\Unit;

class PriceListsDetail extends BaseModel
{
    protected $table = "w_price_list_details";

    public $guarded = ['id'];
    public $translatable = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

}
