<?php

namespace Modules\Common\Entities\Api\Area;

use App\Models\BaseModel;
use Database\Factories\Area\BranchFactory;
use Modules\Common\Entities\Api\Business\Business;

class Branch extends BaseModel
{
    public $translatable = ['name'];
    protected $table = 'c_branches';



    protected $fillable = [
        'code',
        'name',
        'is_active',
        'region_id',
    ];

    protected static function newFactory()
    {
        return BranchFactory::new();
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function business()
    {
        return $this->belongsToMany(Business::class, 'c_branches_business', 'branch_id', 'business_id');
    }
}
