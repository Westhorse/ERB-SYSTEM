<?php

namespace Modules\Common\Entities\Api\Area;

use App\Models\BaseModel;
use Modules\Common\Database\Factories\Area\RegionFactory;

class Region extends BaseModel
{
    public $translatable = ['name'];
    protected $table = 'c_regions';
    protected $fillable = [
        'code',
        'name',
        'is_active',
         'currency_id',
         'time_zone_id'
    ];
    // protected $with=['timeZone','currency'];
    protected static function newFactory()
    {
        return RegionFactory::new();
    }
    // public function timeZone()
    // {
    //     return $this->belongsTo(TimeZone::class);
    // }

    // public function currency()
    // {
    //     return $this->belongsTo(Currency::class);
    // }


}
