<?php

namespace Modules\Common\Entities\Api\Bills;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\BaseModel;

class BillItem extends BaseModel
{
    protected $table = 'c_bills_items';
    protected $fillable = [
        'bill_id', 'warehouse_id',
        'product_id', 'unit_id',
        'item_desc', 'add_qty',
        'converted_add_qty', 'issue_qty',
        'converted_issue_qty', 'unit_price',
        'total_price', 'total_price_with_tax',
    ];
    public $translatable = [];
    protected $casts = [
        'item_desc' => 'json',
    ];

    /**
     * Get all of the tax for the BillItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taxes(): HasMany
    {
        return $this->hasMany(BillItemTax::class, 'bill_item_id', 'id');
    }

    /**
     * Get the bill that owns the BillItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class, 'bill_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($item) {
            $item->taxes()->delete();
        });
    }
    protected static function newFactory()
    {
        return \Modules\Common\Database\factories\Api / Bills / BillItemFactory::new();
    }
}
