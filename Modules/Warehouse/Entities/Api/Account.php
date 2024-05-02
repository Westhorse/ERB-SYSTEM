<?php

namespace  Modules\Warehouse\Entities\Api;

use App\Models\BaseModel;
use  Modules\Warehouse\Entities\Api\Product\ProductCategory;
use  Modules\Warehouse\Entities\Api\Tax\TaxDetail;

class Account extends BaseModel
{
    protected $table = "temp_accounts";

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function taxDetails()
    {
        return $this->hasMany(TaxDetail::class);
    }
}
