<?php

namespace  Modules\Warehouse\Entities\Api\Product;

use App\Models\BaseModel;

class ProductTabulation extends BaseModel
{
    protected $table = "w_products_tabulation";
    public $translatable = ['name','notes'];
    public $guarded = ['id'];


    public function productTabulationDetail()
    {
        return $this->hasMany(ProductTabulationDetail::class,'productTabulation_id');
    }
}
