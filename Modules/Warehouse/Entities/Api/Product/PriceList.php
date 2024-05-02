<?php

namespace  Modules\Warehouse\Entities\Api\Product;

use App\Models\BaseModel;

class PriceList extends BaseModel
{
    protected $table = "w_price_lists";

    public $guarded = ['id'];
    public $translatable = ['name'];

    public function priceListsDetail()
    {
        return $this->hasMany(PriceListsDetail::class,'priceList_id');
    }

}
