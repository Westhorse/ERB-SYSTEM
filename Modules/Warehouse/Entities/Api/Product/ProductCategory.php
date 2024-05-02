<?php

namespace  Modules\Warehouse\Entities\Api\Product;

use App\Models\BaseModel;
use Modules\Common\Entities\Api\Area\Branch;
use Modules\Common\Entities\Api\Tax\Tax;
use Modules\Common\Entities\Api\Vehicle\Account;
use  Modules\Warehouse\Entities\Api\Unit\Unit;

class ProductCategory extends BaseModel
{
    protected $table = "w_product_categories";
    protected $with = ['taxes','products'];
    public $translatable = ['name', 'notes'];
    protected $fillable = [
        'code',
        'parent_id',
        'branch_id',
        'name',
        'unit_id',
        'notes',
        'is_active',
        'taxable',
        'cost_way',
        'apply_tax',
        'product_type',
        'cash_commission',
        'later_commission',
        'commission_type',
        'purchase_disc_type',
        'purchase_disc_amount_type',
        'purchase_disc_amount',
        'cost_price_effect',
        'buy_free_percent',
        'sale_disc_type',
        'sale_disc_amount_type',
        'sale_disc_amount',
        'sale_free_percent',
        'sales_account_id',
        'resales_account_id',
        'purchase_account_id',
        'repurchase_account_id',
        'cost_account_id',
        'stock_account_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($productCategory) {
            $productCategory->taxes()->delete();
        });
    }


    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function salesAccount()
    {
        return $this->belongsTo(Account::class, 'sales_account_id');
    }

    public function resalesAccount()
    {
        return $this->belongsTo(Account::class, 'resales_account_id');
    }

    public function purchaseAccount()
    {
        return $this->belongsTo(Account::class, 'purchase_account_id');
    }

    public function repurchaseAccount()
    {
        return $this->belongsTo(Account::class, 'repurchase_account_id');
    }

    public function costAccount()
    {
        return $this->belongsTo(Account::class, 'cost_account_id');
    }

    public function stockAccount()
    {
        return $this->belongsTo(Account::class, 'stock_account_id');
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'w_product_categories_taxes', 'product_category_id', 'tax_id');
    }

    public function getParent()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'category_id');
    }





}
