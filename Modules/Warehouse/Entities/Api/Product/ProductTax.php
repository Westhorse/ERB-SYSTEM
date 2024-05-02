<?php

namespace  Modules\Warehouse\Entities\Api\Product;

use App\Models\BaseModel;

class ProductTax extends BaseModel
{
    protected $table = "c_taxes";
    public $guarded = [];
    public $translatable = ['name'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'w_products_taxes', 'product_id', 'tax_id');
    }
    
}
