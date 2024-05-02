<?php

namespace  Modules\Warehouse\Entities\Api\Tax;

use App\Models\BaseModel;
use  Modules\Warehouse\Entities\Api\Product\ProductCategory;

class Tax extends BaseModel
{

    protected $table = "c_taxes";
    public $translatable = ['name'];
    protected $fillable = [
        'code', 'name', 'is_active',
    ];

    public function taskDetails()
    {
        return $this->hasMany(TaxDetail::class);
    }
    public function taskDetailsByCountry($country_id)
    {
        return $this->taskDetails()->where('country_id',1);
    }

    public function productCategories()
    {
        return $this->belongsToMany(ProductCategory::class, 'w_product_categories_taxes');
    }
}
