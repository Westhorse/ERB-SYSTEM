<?php

namespace Modules\Warehouse\Entities\Api\Inventory;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inventory extends BaseModel
{
    use HasFactory;
    protected $table = "w_inventories";

    public $translatable = ['name', 'remarks'];
    protected $fillable = [
        'code',
        'name',
        'inventory_date',
        'warehouse_id',
        'currency_id',
        'conversion_factor',
        'remarks',
        'inventory_type',
        'is_approved',
    ];
    protected static function newFactory()
    {
        return \Modules\Warehouse\Database\factories\Api / Inventory / InventoryFactory::new();
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($inventory) {
            $inventory->items()->delete();
            $inventory->list()->delete();
        });
    }

    /**
     * Get all of the items for the Inventory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(InventoryItem::class, 'inventory_id', 'id');
    }

    /**
     * Get the list that owns the Inventory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function listToBelong(): BelongsTo
    {
        return $this->belongsTo(InventoryList::class, 'id', 'inventory_id');
    }
    /**
     * Get the list that owns the Inventory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function listInventories(): BelongsTo
    {
        return $this->belongsTo(InventoryList::class, 'id', 'src_inventory_id');
    }

    /**
     * Get the list associated with the Inventory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function list(): HasOne
    {
        return $this->hasOne(InventoryList::class, 'inventory_id', 'id');
    }
}
