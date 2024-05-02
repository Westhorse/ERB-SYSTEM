<?php

namespace Modules\Warehouse\Entities\Api\Inventory;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryItem extends BaseModel
{
    use HasFactory;
    protected $table = "w_inventory_items";

    public $translatable = ['remarks'];
    protected $fillable = [
        'inventory_id',
        'product_id',
        'product_qty',
        'remarks',
    ];
    protected static function newFactory()
    {
        return \Modules\Warehouse\Database\factories\Api / Inventory / InventoryItemFactory::new();
    }
}
