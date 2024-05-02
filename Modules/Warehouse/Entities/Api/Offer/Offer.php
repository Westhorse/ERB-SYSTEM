<?php

namespace  Modules\Warehouse\Entities\Api\Offer;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Warehouse\Entities\Api\Warehouse\Warehouse;

class Offer extends BaseModel
{
    protected $table = "w_offers";
    public $translatable = ['name', 'notes'];
    protected $fillable = [
        'code', 'name', 'notes', 'from_date', 'to_date', 'warehouse_id', 'is_active',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'w_warehouses');
    }

    public function offerDetails()
    {
        return $this->hasMany(OfferDetail::class);
    }
}
