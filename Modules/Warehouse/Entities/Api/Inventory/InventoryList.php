<?php

namespace Modules\Warehouse\Entities\Api\Inventory;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryList extends BaseModel
{
    use HasFactory;
    protected $table = "w_inventory_lists";

    public $translatable = [];
    protected $fillable = [
        'inventory_id',
        'src_inventory_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Warehouse\Database\factories\Api / Inventory / InventoryListFactory::new();
    }
}
