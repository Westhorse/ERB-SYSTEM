<?php

namespace  Modules\Warehouse\Entities\Api\Warehouse;

use App\Models\BaseModel;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Common\Entities\Api\Area\Branch;
use Modules\Common\Entities\Api\Localization\District;
use  Modules\Warehouse\Entities\Api\Offer\Offer;
use  Modules\Warehouse\Entities\Api\Offer\OfferDetail;

class Warehouse extends BaseModel
{
    protected $table = "w_warehouses";
    public $translatable = ['name', 'address', 'notes'];

    protected $fillable = [
        'name', 'address', 'notes', 'is_active', 'code', 'address_map',
        'lat', 'long', 'fp_account_id', 'lp_account_id', 'effect_in_store_value',
        'district_id', 'branch_id', 'in_bill_type_id', 'out_bill_type_id',
        'warehouse_keeper_id', 'warehouse_keeper', 'parent_id', "driver_id"
    ];



    /**
     * Get the district that owns the Warehouse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the branch that owns the Warehouse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function parent()
    {
        return $this->belongsTo(Warehouse::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Warehouse::class, 'parent_id')->with('children');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function offerDetails()
    {
        return $this->hasMany(OfferDetail::class);
    }

    public function scopeParents()
    {

        $parents = collect([]);

        $parent = $this->parent;

        while (!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }

    public function childsIDs()
    {
        return $this->children()->pluck('id');
    }
}
