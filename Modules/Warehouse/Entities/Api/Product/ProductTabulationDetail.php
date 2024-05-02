<?php

namespace  Modules\Warehouse\Entities\Api\Product;

use App\Models\BaseModel;

class ProductTabulationDetail extends BaseModel
{
    protected $table = "w_products_tabulation_details";

    public $guarded = ['id'];
    public $translatable = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
