<?php

namespace  Modules\Warehouse\Entities\Api\Product;

use App\Models\BaseModel;
use Modules\Common\Entities\Api\Tax\Tax;
use  Modules\Warehouse\Entities\Api\Guarantee\Guarantee;
use  Modules\Warehouse\Entities\Api\Image\Image;
use  Modules\Warehouse\Entities\Api\Offer\OfferDetail;
use  Modules\Warehouse\Entities\Api\Supplier\Supplier;
use  Modules\Warehouse\Entities\Api\Tag\Tag;
use  Modules\Warehouse\Entities\Api\Unit\Unit;
use  Modules\Warehouse\Entities\Api\Warehouse\Warehouse;

class Product extends BaseModel
{
    protected $table = "w_products";
    protected $guarded = ['id'];
    public $translatable = ['name', 'description'];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function gurantee()
    {
        return $this->belongsTo(Guarantee::class, 'guarantee_id');
    }

    public function productUnit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'w_products_suppliers', 'product_id', 'supplier_id');
    }

    public function determinants()
    {
        return $this->belongsToMany(Determinant::class, 'w_proudcts_determinants', 'product_id', 'determinant_id')
            ->withPivot('in_product_balanct', 'in_product_qty');
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'w_products_taxes', 'product_id', 'tax_id')->withPivot('product_id', 'tax_id');
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'w_products_warehouses', 'product_id', 'warehouse_id')
            ->withPivot('item_location', 'min_level', 'max_level', 'reload_level');
    }
    public function compounds()
    {
        return $this->belongsToMany(Product::class, 'w_product_compound', 'product_id', 'src_product_id')
            ->withPivot('product_qty', 'cost_price', 'sell_price');
    }

    public function alternatives()
    {
        return $this->belongsToMany(Product::class, 'w_alternative_products', 'main_product_id', 'alternate_product_id')
            ->withPivot('alternative_type');
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'w_products_units', 'product_id', 'unit_id')->withPivot('convert_rate', 'sales_price', 'min_sales_price', 'barcode', 'weight');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'w_products_tags', 'product_id', 'tag_id');
    }

    public function productUnits()
    {
        return $this->belongsToMany(Unit::class, 'w_products_units', 'product_id', 'unit_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function offerDetails()
    {
        return $this->hasMany(OfferDetail::class);
    }
}
